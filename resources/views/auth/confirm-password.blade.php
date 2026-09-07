<x-auth-layout>
    <h1 class="font-display text-4xl">Confirm password</h1>
    <p class="mt-2 text-ink/60">This is a secure area. Please confirm your password to continue.</p>
    <form method="POST" action="{{ route('password.confirm') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-medium">Password</label>
            <input name="password" type="password" required
                   class="w-full rounded-2xl border border-ink/10 bg-white px-4 py-3 outline-none ring-gold/40 focus:ring-2">
            @error('password') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
        </div>
        <button class="w-full rounded-full bg-ink py-3.5 font-semibold text-paper">Confirm</button>
    </form>
</x-auth-layout>
