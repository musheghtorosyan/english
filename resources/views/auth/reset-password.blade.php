<x-auth-layout>
    <h1 class="font-display text-4xl">Reset password</h1>
    <p class="mt-2 text-ink/60">Choose a new password for your studio.</p>

    <form method="POST" action="{{ route('password.store') }}" class="mt-8 space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <label class="mb-2 block text-sm font-medium">Email</label>
            <input name="email" type="email" value="{{ old('email', $request->email) }}" required
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
        <button class="w-full rounded-full bg-ink py-3.5 font-semibold text-paper">Save new password</button>
    </form>
</x-auth-layout>
