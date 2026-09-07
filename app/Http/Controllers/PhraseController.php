<?php

namespace App\Http\Controllers;

use App\Models\Phrase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhraseController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $levels = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
        $categories = ['idiom', 'phrasal_verb', 'collocation'];

        $query = Phrase::query()->orderBy('phrase');

        if ($search = trim((string) $request->get('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder->where('phrase', 'like', "%{$search}%")
                    ->orWhere('translation_hy', 'like', "%{$search}%")
                    ->orWhere('translation_ru', 'like', "%{$search}%")
                    ->orWhere('example_en', 'like', "%{$search}%");
            });
        }

        if (in_array($request->get('level'), $levels, true)) {
            $query->where('level', $request->get('level'));
        }

        if (in_array($request->get('category'), $categories, true)) {
            $query->where('category', $request->get('category'));
        }

        $status = $request->get('status');
        if ($status === 'learned') {
            $query->whereHas('learners', fn ($builder) => $builder->where('users.id', $user->id));
        } elseif ($status === 'new') {
            $query->whereDoesntHave('learners', fn ($builder) => $builder->where('users.id', $user->id));
        }

        $phrases = $query->paginate(18)->withQueryString();
        $learnedIds = $user->phrases()->pluck('phrases.id')->all();

        return view('phrases.index', [
            'phrases' => $phrases,
            'learnedIds' => $learnedIds,
            'levels' => $levels,
            'categories' => $categories,
        ]);
    }

    public function toggle(Request $request, Phrase $phrase): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        $attached = $user->phrases()->where('phrase_id', $phrase->id)->exists();

        if ($attached) {
            $user->phrases()->detach($phrase->id);
            $learned = false;
        } else {
            $user->phrases()->attach($phrase->id, ['learned_at' => now()]);
            $user->recordStudyDay();
            $learned = true;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'learned' => $learned,
                'learned_count' => $user->phrases()->count(),
            ]);
        }

        return back();
    }
}
