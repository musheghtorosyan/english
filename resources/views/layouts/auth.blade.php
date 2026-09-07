<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'HayEnglish' }} — {{ config('app.name', 'HayEnglish') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Armenian:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-paper font-sans antialiased">
    <div class="grid min-h-screen lg:grid-cols-2">
        <div class="auth-panel relative hidden overflow-hidden p-12 text-white lg:flex lg:flex-col lg:justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-white">
                <x-application-logo />
                <span class="font-display text-2xl">HayEnglish</span>
            </a>
            <div>
                <div class="text-sm uppercase tracking-[0.25em] text-gold-soft">English studio</div>
                <h2 class="mt-4 font-display text-5xl leading-tight">Words you will actually use.</h2>
                <p class="mt-4 max-w-md text-white/70">A1 to C2 vocabulary for Armenians, with Russian as a second support language. Mark a word once — it stays green.</p>
            </div>
            <p class="text-sm text-white/50">Հայերեն · English · Русский</p>
        </div>
        <div class="flex items-center px-6 py-12">
            <div class="mx-auto w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
