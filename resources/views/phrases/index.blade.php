<x-app-layout>
    <x-slot name="eyebrow">Idioms · Կայուն արտահայտություններ</x-slot>
    <x-slot name="heading">Set phrases</x-slot>

    <form method="GET" class="rounded-3xl bg-white p-4 shadow-sm lg:p-5">
        <div class="grid gap-3 md:grid-cols-[1fr_150px_170px_150px_auto]">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search phrases, հայերեն, русский"
                   class="rounded-2xl border border-ink/10 bg-paper px-4 py-3 outline-none ring-gold/40 focus:ring-2">
            <select name="level" class="rounded-2xl border border-ink/10 bg-paper px-4 py-3">
                <option value="">All levels</option>
                @foreach ($levels as $level)
                    <option value="{{ $level }}" @selected(request('level') === $level)>{{ $level }}</option>
                @endforeach
            </select>
            <select name="category" class="rounded-2xl border border-ink/10 bg-paper px-4 py-3">
                <option value="">All types</option>
                <option value="idiom" @selected(request('category') === 'idiom')">Idiom</option>
                <option value="phrasal_verb" @selected(request('category') === 'phrasal_verb')">Phrasal verb</option>
                <option value="collocation" @selected(request('category') === 'collocation')">Collocation</option>
            </select>
            <select name="status" class="rounded-2xl border border-ink/10 bg-paper px-4 py-3">
                <option value="">All</option>
                <option value="new" @selected(request('status') === 'new')">Not learned</option>
                <option value="learned" @selected(request('status') === 'learned')">Learned</option>
            </select>
            <button class="rounded-2xl bg-ink px-5 py-3 font-semibold text-paper">Filter</button>
        </div>
    </form>

    <div class="mt-6 grid gap-4 lg:grid-cols-2">
        @foreach ($phrases as $phrase)
            @php $learned = in_array($phrase->id, $learnedIds, true); @endphp
            <article
                x-data="{ learned: {{ $learned ? 'true' : 'false' }}, busy: false }"
                :class="learned ? 'learned-card' : ''"
                class="rounded-3xl bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full px-2 py-0.5 text-xs level-{{ $phrase->level }}">{{ $phrase->level }}</span>
                            <span class="rounded-full bg-paper px-2 py-0.5 text-xs text-ink/60">{{ $phrase->categoryLabel() }}</span>
                        </div>
                        <h2 class="mt-2 font-display text-2xl">{{ $phrase->phrase }}</h2>
                    </div>
                    <button type="button"
                            :disabled="busy"
                            @click="
                                busy = true;
                                fetch('{{ route('phrases.toggle', $phrase) }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                }).then(r => r.json()).then(data => { learned = data.learned; busy = false; })
                            "
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border text-lg"
                            :class="learned ? 'border-mark bg-mark text-white' : 'border-ink/10 text-ink/30 hover:border-mark hover:text-mark'">
                        ✓
                    </button>
                </div>
                <div class="mt-3 space-y-1">
                    <div><span class="text-xs text-ink/40">HY</span> {{ $phrase->translation_hy }}</div>
                    <div><span class="text-xs text-ink/40">RU</span> <span class="text-ink/70">{{ $phrase->translation_ru }}</span></div>
                </div>
                @if ($phrase->example_en)
                    <p class="mt-3 rounded-2xl bg-paper px-4 py-3 text-sm italic text-ink/70">{{ $phrase->example_en }}</p>
                @endif
            </article>
        @endforeach
    </div>

    <div class="mt-8">{{ $phrases->onEachSide(1)->links() }}</div>
</x-app-layout>
