<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'HayEnglish') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Armenian:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-paper font-sans text-ink antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen lg:grid lg:grid-cols-[280px_1fr]">
        <aside class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full bg-navy text-white transition lg:static lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            <div class="flex h-full flex-col px-5 py-6">
                <a href="{{ route('dashboard') }}" class="mb-10 flex items-center gap-3">
                    <x-application-logo />
                    <div>
                        <div class="font-display text-xl leading-none">HayEnglish</div>
                        <div class="mt-1 text-xs text-gold-soft">Անգլերեն հայերենով</div>
                    </div>
                </a>

                <nav class="space-y-1 text-sm">
                    @php
                        $links = [
                            ['dashboard', 'Dashboard', 'Վահանակ', 'M3 12l9-9 9 9M5 10v10h14V10'],
                            ['dictionary.index', 'Dictionary', 'Բառարան', 'M4 19V5a2 2 0 012-2h9l5 5v11a2 2 0 01-2 2H6a2 2 0 01-2-2z'],
                            ['phrases.index', 'Set phrases', 'Կայուն արտահայտություններ', 'M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01'],
                            ['profile.edit', 'Profile', 'Պրոֆիլ', 'M12 12a4 4 0 100-8 4 4 0 000 8zM4 20a8 8 0 0116 0'],
                        ];
                    @endphp
                    @foreach ($links as [$route, $en, $hy, $icon])
                        <a href="{{ route($route) }}"
                           class="sidebar-link flex items-center gap-3 rounded-2xl px-3 py-3 text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs($route) ? 'active' : '' }}">
                            <svg class="h-5 w-5 shrink-0 text-gold-soft" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                            </svg>
                            <span>
                                <span class="block font-medium">{{ $en }}</span>
                                <span class="block text-[11px] text-white/50">{{ $hy }}</span>
                            </span>
                        </a>
                    @endforeach
                </nav>

                <div class="mt-auto rounded-3xl bg-white/5 p-4">
                    <div class="text-xs uppercase tracking-[0.2em] text-gold-soft">Today</div>
                    <div class="mt-2 font-display text-2xl">{{ auth()->user()->streak_days }} day streak</div>
                    <div class="mt-1 text-sm text-white/60">Keep one green mark every day.</div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button class="w-full rounded-2xl px-3 py-2 text-left text-sm text-white/60 hover:bg-white/10 hover:text-white">
                        Log out · Դուրս գալ
                    </button>
                </form>
            </div>
        </aside>

        <div class="min-h-screen">
            <header class="sticky top-0 z-20 flex items-center justify-between border-b border-ink/10 bg-paper/90 px-4 py-4 backdrop-blur lg:px-8">
                <button class="rounded-xl p-2 text-ink lg:hidden" @click="sidebarOpen = true" type="button">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
                <div>
                    <div class="text-sm text-ink/50">{{ $eyebrow ?? 'Learning studio' }}</div>
                    <h1 class="font-display text-2xl">{{ $heading ?? 'Dashboard' }}</h1>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden text-right sm:block">
                        <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-ink/50">{{ auth()->user()->preferred_translation === 'ru' ? 'EN → RU' : 'EN → HY' }}</div>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-ink text-sm font-semibold text-paper">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="px-4 py-6 lg:px-8 lg:py-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    <div class="fixed inset-0 z-30 bg-black/40 lg:hidden" x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"></div>
</body>
</html>
