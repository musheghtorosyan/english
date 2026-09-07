<x-app-layout>
    <x-slot name="eyebrow">Overview · Ընդհանուր</x-slot>
    <x-slot name="heading">Your English studio</x-slot>

    <div class="grid gap-5 xl:grid-cols-4">
        <div class="rounded-3xl bg-ink p-6 text-paper">
            <div class="text-xs uppercase tracking-[0.2em] text-gold-soft">Words</div>
            <div class="mt-3 font-display text-4xl">{{ number_format($learnedWords) }}</div>
            <div class="mt-1 text-sm text-white/60">of {{ number_format($totalWords) }} marked green</div>
            <div class="mt-4 h-2 rounded-full bg-white/10">
                <div class="h-2 rounded-full bg-mark" style="width: {{ $wordPercent }}%"></div>
            </div>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="text-xs uppercase tracking-[0.2em] text-ink/40">Phrases</div>
            <div class="mt-3 font-display text-4xl">{{ number_format($learnedPhrases) }}</div>
            <div class="mt-1 text-sm text-ink/50">of {{ number_format($totalPhrases) }} set phrases</div>
            <div class="mt-4 h-2 rounded-full bg-ink/10">
                <div class="h-2 rounded-full bg-gold" style="width: {{ $phrasePercent }}%"></div>
            </div>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="text-xs uppercase tracking-[0.2em] text-ink/40">Daily goal</div>
            <div class="mt-3 font-display text-4xl">{{ $todayLearned }}/{{ auth()->user()->daily_goal }}</div>
            <div class="mt-1 text-sm text-ink/50">new green marks today</div>
            <div class="mt-4 h-2 rounded-full bg-ink/10">
                <div class="h-2 rounded-full bg-emerald" style="width: {{ $goalPercent }}%"></div>
            </div>
        </div>
        <div class="rounded-3xl bg-gold p-6">
            <div class="text-xs uppercase tracking-[0.2em] text-ink/60">Streak</div>
            <div class="mt-3 font-display text-4xl">{{ auth()->user()->streak_days }}</div>
            <div class="mt-1 text-sm text-ink/70">days in a row</div>
        </div>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <section class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="font-display text-2xl">CEFR progress</h2>
                <a href="{{ route('dictionary.index') }}" class="text-sm font-semibold text-emerald">Open dictionary</a>
            </div>
            <div class="space-y-4">
                @foreach ($progress as $row)
                    <div>
                        <div class="mb-1 flex items-center justify-between text-sm">
                            <span class="inline-flex items-center gap-2 font-semibold">
                                <span class="rounded-full px-2 py-0.5 text-xs level-{{ $row['level'] }}">{{ $row['level'] }}</span>
                                {{ $row['learned'] }} / {{ $row['total'] }}
                            </span>
                            <span class="text-ink/50">{{ $row['percent'] }}%</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-paper">
                            <div class="h-2.5 rounded-full bg-emerald" style="width: {{ $row['percent'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="font-display text-2xl">Word of the day</h2>
            @if ($wordOfDay)
                <div class="mt-4">
                    <div class="flex items-center gap-2">
                        <span class="rounded-full px-2 py-0.5 text-xs level-{{ $wordOfDay->level }}">{{ $wordOfDay->level }}</span>
                        <span class="text-xs uppercase tracking-wider text-ink/40">{{ $wordOfDay->part_of_speech }}</span>
                    </div>
                    <div class="mt-3 font-display text-4xl">{{ $wordOfDay->word }}</div>
                    <div class="mt-3 text-lg">{{ $wordOfDay->translation_hy }}</div>
                    <div class="text-ink/50">{{ $wordOfDay->translation_ru }}</div>
                    <form method="POST" action="{{ route('dictionary.toggle', $wordOfDay) }}" class="mt-5">
                        @csrf
                        <button class="rounded-full bg-mark px-5 py-2.5 text-sm font-semibold text-white">Mark as learned</button>
                    </form>
                </div>
            @endif
        </section>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <section class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="font-display text-2xl">Recently learned words</h2>
            <div class="mt-4 divide-y divide-ink/5">
                @forelse ($recentWords as $word)
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <div class="font-semibold">{{ $word->word }}</div>
                            <div class="text-sm text-ink/50">{{ $word->translation_hy }} · {{ $word->translation_ru }}</div>
                        </div>
                        <span class="text-mark">✓</span>
                    </div>
                @empty
                    <p class="py-6 text-sm text-ink/50">No green marks yet. Open the dictionary and start with A1.</p>
                @endforelse
            </div>
        </section>
        <section class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-2xl">Set phrases</h2>
                <a href="{{ route('phrases.index') }}" class="text-sm font-semibold text-emerald">All phrases</a>
            </div>
            <div class="mt-4 divide-y divide-ink/5">
                @forelse ($recentPhrases as $phrase)
                    <div class="py-3">
                        <div class="font-semibold">{{ $phrase->phrase }}</div>
                        <div class="text-sm text-ink/50">{{ $phrase->translation_hy }}</div>
                    </div>
                @empty
                    <p class="py-6 text-sm text-ink/50">Learn idioms and phrasal verbs on the set phrases page.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
