<x-auth-layout>
    <a href="{{ route('home') }}" class="mb-8 flex items-center gap-3 lg:hidden">
        <x-application-logo />
        <span class="font-display text-2xl">HayEnglish</span>
    </a>
    <div class="text-sm text-ink/50">Welcome back · Բարի վերադարձ</div>
    <h1 class="mt-2 font-display text-4xl">Log in</h1>
    <p class="mt-2 text-ink/60">Continue your English studio.</p>

    @if (session('status'))
        <div class="mt-6 rounded-2xl bg-emerald/10 px-4 py-3 text-sm text-emerald">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-medium">Email</label>
            <input name="email" type="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-2xl border border-ink/10 bg-white px-4 py-3 outline-none ring-gold/40 focus:ring-2">
            @error('email') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
        </div>
        <div>
            <div class="mb-2 flex items-center justify-between text-sm">
                <label class="font-medium">Password</label>
                <a href="{{ route('password.request') }}" class="text-emerald hover:underline">Forgot?</a>
            </div>
            <input name="password" type="password" required
                   class="w-full rounded-2xl border border-ink/10 bg-white px-4 py-3 outline-none ring-gold/40 focus:ring-2">
            @error('password') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
        </div>
        <label class="flex items-center gap-3 text-sm text-ink/70">
            <input type="checkbox" name="remember" class="rounded border-ink/20 text-emerald focus:ring-emerald">
            Remember me
        </label>
        <button class="w-full rounded-full bg-ink py-3.5 font-semibold text-paper">Enter the studio</button>
    </form>
    <p class="mt-6 text-sm text-ink/60">No account yet? <a href="{{ route('register') }}" class="font-semibold text-emerald">Create one</a></p>
</x-auth-layout>
