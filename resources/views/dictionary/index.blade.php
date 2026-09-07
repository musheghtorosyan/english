<x-app-layout>
    <x-slot name="eyebrow">Vocabulary · Բառապաշար</x-slot>
    <x-slot name="heading">Dictionary</x-slot>

    @php
        $letters = range('A', 'Z');
        $toggleUrl = fn ($word) => route('dictionary.toggle', $word);
    @endphp

    <form method="GET" class="rounded-3xl bg-white p-4 shadow-sm lg:p-5">
        <div class="grid gap-3 md:grid-cols-[1fr_160px_160px_auto]">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search English, հայերեն, русский"
                   class="rounded-2xl border border-ink/10 bg-paper px-4 py-3 outline-none ring-gold/40 focus:ring-2">
            <select name="level" class="rounded-2xl border border-ink/10 bg-paper px-4 py-3">
                <option value="">All levels</option>
                @foreach ($levels as $level)
                    <option value="{{ $level }}" @selected(request('level') === $level)>{{ $level }}</option>
                @endforeach
            </select>
            <select name="status" class="rounded-2xl border border-ink/10 bg-paper px-4 py-3">
                <option value="">All words</option>
                <option value="new" @selected(request('status') === 'new')">Not learned</option>
                <option value="learned" @selected(request('status') === 'learned')">Learned</option>
            </select>
            <button class="rounded-2xl bg-ink px-5 py-3 font-semibold text-paper">Filter</button>
        </div>
        <div class="mt-4 flex flex-wrap gap-1">
            <a href="{{ route('dictionary.index', request()->except('letter')) }}"
               class="rounded-lg px-2 py-1 text-xs {{ !request('letter') ? 'bg-ink text-paper' : 'bg-paper text-ink/60' }}">All</a>
            @foreach ($letters as $letter)
                <a href="{{ route('dictionary.index', array_merge(request()->except('page'), ['letter' => $letter])) }}"
                   class="rounded-lg px-2 py-1 text-xs {{ request('letter') === $letter ? 'bg-ink text-paper' : 'bg-paper text-ink/60 hover:bg-gold-soft' }}">{{ $letter }}</a>
            @endforeach
        </div>
    </form>

    <div class="mt-4 flex gap-4 text-sm text-ink/60">
        <span>{{ number_format($counts['all']) }} words</span>
        <span class="text-mark">{{ number_format($counts['learned']) }} learned</span>
        <span>{{ number_format($counts['new']) }} remaining</span>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($words as $word)
            @php $learned = in_array($word->id, $learnedIds, true); @endphp
            <article
                x-data="{ learned: {{ $learned ? 'true' : 'false' }}, busy: false }"
                :class="learned ? 'learned-card' : ''"
                class="rounded-3xl bg-white p-5 shadow-sm transition">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="rounded-full px-2 py-0.5 text-xs level-{{ $word->level }}">{{ $word->level }}</span>
                            @if ($word->part_of_speech)
                                <span class="text-xs uppercase tracking-wider text-ink/40">{{ $word->part_of_speech }}</span>
                            @endif
                        </div>
                        <h2 class="mt-2 font-display text-3xl">{{ $word->word }}</h2>
                    </div>
                    <button type="button"
                            :disabled="busy"
                            @click="
                                busy = true;
                                fetch('{{ route('dictionary.toggle', $word) }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                }).then(r => r.json()).then(data => { learned = data.learned; busy = false; })
                            "
                            class="flex h-11 w-11 items-center justify-center rounded-full border text-lg"
                            :class="learned ? 'border-mark bg-mark text-white' : 'border-ink/10 text-ink/30 hover:border-mark hover:text-mark'">
                        ✓
                    </button>
                </div>
                <div class="mt-4 space-y-1">
                    <div><span class="text-xs text-ink/40">HY</span> <span class="text-lg">{{ $word->translation_hy ?: '—' }}</span></div>
                    <div><span class="text-xs text-ink/40">RU</span> <span class="text-ink/70">{{ $word->translation_ru ?: '—' }}</span></div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-8">{{ $words->onEachSide(1)->links() }}</div>
</x-app-layout>
