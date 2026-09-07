<x-auth-layout>
    <a href="{{ route('home') }}" class="mb-8 flex items-center gap-3 lg:hidden">
        <x-application-logo />
        <span class="font-display text-2xl">HayEnglish</span>
    </a>
    <div class="text-sm text-ink/50">New learner · Նոր ուսանող</div>
    <h1 class="mt-2 font-display text-4xl">Create account</h1>
    <p class="mt-2 text-ink/60">Save your green marks across 20,000 words.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-medium">Name</label>
            <input name="name" type="text" value="{{ old('name') }}" required autofocus
                   class="w-full rounded-2xl border border-ink/10 bg-white px-4 py-3 outline-none ring-gold/40 focus:ring-2">
            @error('name') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium">Email</label>
            <input name="email" type="email" value="{{ old('email') }}" required
                   class="w-full rounded-2xl border border-ink/10 bg-white px-4 py-3 outline-none ring-gold/40 focus:ring-2">
            @error('email') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium">Password</label>
            <input name="password" type="password" required
                   class="w-full rounded-2xl border border-ink/10 bg-white px-4 py-3 outline-none ring-gold/40 focus:ring-2">
            @error('password') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium">Confirm password</label>
            <input name="password_confirmation" type="password" required
                   class="w-full rounded-2xl border border-ink/10 bg-white px-4 py-3 outline-none ring-gold/40 focus:ring-2">
        </div>
        <button class="w-full rounded-full bg-emerald py-3.5 font-semibold text-white">Start learning</button>
    </form>
    <p class="mt-6 text-sm text-ink/60">Already registered? <a href="{{ route('login') }}" class="font-semibold text-emerald">Log in</a></p>
</x-auth-layout>
