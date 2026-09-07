<x-auth-layout>
    <h1 class="font-display text-4xl">Forgot password</h1>
    <p class="mt-2 text-ink/60">We will send a reset link to your email.</p>

    @if (session('status'))
        <div class="mt-6 rounded-2xl bg-emerald/10 px-4 py-3 text-sm text-emerald">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-medium">Email</label>
            <input name="email" type="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-2xl border border-ink/10 bg-white px-4 py-3 outline-none ring-gold/40 focus:ring-2">
            @error('email') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
        </div>
        <button class="w-full rounded-full bg-ink py-3.5 font-semibold text-paper">Send reset link</button>
    </form>
    <p class="mt-6 text-sm"><a href="{{ route('login') }}" class="font-semibold text-emerald">Back to login</a></p>
</x-auth-layout>
