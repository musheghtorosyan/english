<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DictionaryController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $levels = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];

        $query = Word::query()->orderBy('frequency_rank');

        if ($search = trim((string) $request->get('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder->where('word', 'like', "%{$search}%")
                    ->orWhere('translation_hy', 'like', "%{$search}%")
                    ->orWhere('translation_ru', 'like', "%{$search}%");
            });
        }

        if (in_array($request->get('level'), $levels, true)) {
            $query->where('level', $request->get('level'));
        }

        if ($letter = strtoupper((string) $request->get('letter'))) {
            if (preg_match('/^[A-Z]$/', $letter)) {
                $query->where('word', 'like', strtolower($letter).'%');
            }
        }

        $status = $request->get('status');
        if ($status === 'learned') {
            $query->whereHas('learners', fn ($builder) => $builder->where('users.id', $user->id));
        } elseif ($status === 'new') {
            $query->whereDoesntHave('learners', fn ($builder) => $builder->where('users.id', $user->id));
        }

        $words = $query->paginate(24)->withQueryString();
        $learnedIds = $user->words()->pluck('words.id')->all();

        $counts = [
            'all' => Word::query()->count(),
            'learned' => $user->words()->count(),
        ];
        $counts['new'] = $counts['all'] - $counts['learned'];

        return view('dictionary.index', [
            'words' => $words,
            'learnedIds' => $learnedIds,
            'levels' => $levels,
            'counts' => $counts,
        ]);
    }

    public function toggle(Request $request, Word $word): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        $attached = $user->words()->where('word_id', $word->id)->exists();

        if ($attached) {
            $user->words()->detach($word->id);
            $learned = false;
        } else {
            $user->words()->attach($word->id, ['learned_at' => now()]);
            $user->recordStudyDay();
            $learned = true;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'learned' => $learned,
                'learned_count' => $user->words()->count(),
            ]);
        }

        return back();
    }
}
