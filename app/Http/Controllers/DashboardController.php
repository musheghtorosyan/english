<?php

namespace App\Http\Controllers;

use App\Models\Phrase;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $totalWords = Word::query()->count();
        $totalPhrases = Phrase::query()->count();
        $learnedWords = $user->words()->count();
        $learnedPhrases = $user->phrases()->count();

        $todayLearned = $user->words()
            ->whereDate('user_word.learned_at', now()->toDateString())
            ->count()
            + $user->phrases()
                ->whereDate('user_phrase.learned_at', now()->toDateString())
                ->count();

        $levelStats = Word::query()
            ->selectRaw('level, count(*) as total')
            ->groupBy('level')
            ->pluck('total', 'level');

        $learnedByLevel = $user->words()
            ->selectRaw('words.level, count(*) as total')
            ->groupBy('words.level')
            ->pluck('total', 'level');

        $levels = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
        $progress = collect($levels)->map(function (string $level) use ($levelStats, $learnedByLevel) {
            $total = (int) ($levelStats[$level] ?? 0);
            $learned = (int) ($learnedByLevel[$level] ?? 0);

            return [
                'level' => $level,
                'total' => $total,
                'learned' => $learned,
                'percent' => $total > 0 ? (int) round($learned / $total * 100) : 0,
            ];
        });

        $dayIndex = now()->dayOfYear;
        $wordOfDay = Word::query()
            ->whereNotIn('id', $user->words()->pluck('words.id'))
            ->orderBy('frequency_rank')
            ->offset($dayIndex % max($totalWords - $learnedWords, 1))
            ->first() ?? Word::query()->orderBy('frequency_rank')->first();

        $recentWords = $user->words()
            ->orderByPivot('learned_at', 'desc')
            ->limit(8)
            ->get();

        $recentPhrases = $user->phrases()
            ->orderByPivot('learned_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'totalWords' => $totalWords,
            'totalPhrases' => $totalPhrases,
            'learnedWords' => $learnedWords,
            'learnedPhrases' => $learnedPhrases,
            'todayLearned' => $todayLearned,
            'progress' => $progress,
            'wordOfDay' => $wordOfDay,
            'recentWords' => $recentWords,
            'recentPhrases' => $recentPhrases,
            'wordPercent' => $totalWords > 0 ? (int) round($learnedWords / $totalWords * 100) : 0,
            'phrasePercent' => $totalPhrases > 0 ? (int) round($learnedPhrases / $totalPhrases * 100) : 0,
            'goalPercent' => $user->daily_goal > 0 ? min(100, (int) round($todayLearned / $user->daily_goal * 100)) : 0,
        ]);
    }
}
