<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HayEnglish — Անգլերեն հայերենով</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Armenian:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-paper font-sans text-ink antialiased">
    <header class="mx-auto flex max-w-6xl items-center justify-between px-6 py-6">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <x-application-logo />
            <div>
                <div class="font-display text-2xl">HayEnglish</div>
                <div class="text-xs text-ink/50">English · Հայերեն · Русский</div>
            </div>
        </a>
        <nav class="flex items-center gap-3 text-sm">
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-full bg-ink px-5 py-2.5 font-medium text-paper">Open studio</a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-ink/70 hover:text-ink">Log in</a>
                <a href="{{ route('register') }}" class="rounded-full bg-ink px-5 py-2.5 font-medium text-paper">Start learning</a>
            @endauth
        </nav>
    </header>

    <section class="mx-auto grid max-w-6xl items-center gap-12 px-6 pb-20 pt-8 lg:grid-cols-2 lg:pt-16">
        <div>
            <div class="mb-4 inline-flex rounded-full bg-gold-soft px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-ink">A1 → C2</div>
            <h1 class="font-display text-5xl leading-tight sm:text-6xl">Learn English the Armenian way.</h1>
            <p class="mt-5 max-w-xl text-lg leading-8 text-ink/70">
                20,000 most used English words with Armenian and Russian translations, plus 1,000 set phrases.
                Mark every word you already know — it turns green and stays in your progress.
            </p>
            <p class="mt-3 text-base text-ink/60">20.000 ամենագործածական բառեր և 1.000 կայուն արտահայտություններ։</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('register') }}" class="rounded-full bg-emerald px-6 py-3 font-semibold text-white">Create free account</a>
                <a href="{{ route('login') }}" class="rounded-full border border-ink/15 px-6 py-3 font-semibold">I already have an account</a>
            </div>
        </div>
        <div class="grid gap-4">
            <div class="learned-card rounded-3xl bg-paper-soft p-6 shadow-sm">
                <div class="text-xs uppercase tracking-[0.2em] text-emerald">Learned</div>
                <div class="mt-2 font-display text-4xl">beautiful</div>
                <div class="mt-3 text-lg">գեղեցիկ</div>
                <div class="text-ink/50">красивый</div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-3xl bg-ink p-6 text-paper">
                    <div class="text-3xl font-display">20,000</div>
                    <div class="mt-1 text-sm text-white/60">dictionary words</div>
                </div>
                <div class="rounded-3xl bg-gold p-6 text-ink">
                    <div class="text-3xl font-display">1,000</div>
                    <div class="mt-1 text-sm">set phrases</div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
