<x-app-layout>
    <x-slot name="eyebrow">Account · Հաշիվ</x-slot>
    <x-slot name="heading">Profile</x-slot>

    <div class="grid gap-6 xl:grid-cols-2">
        <section class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="font-display text-2xl">Profile information</h2>
            <p class="mt-1 text-sm text-ink/50">Update your name, email and learning preference.</p>

            @if (session('status') === 'profile-updated')
                <div class="mt-4 rounded-2xl bg-emerald/10 px-4 py-3 text-sm text-emerald">Saved.</div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
                @csrf
                @method('patch')
                <div>
                    <label class="mb-2 block text-sm font-medium">Name</label>
                    <input name="name" value="{{ old('name', $user->name) }}"
                           class="w-full rounded-2xl border border-ink/10 bg-paper px-4 py-3 outline-none ring-gold/40 focus:ring-2">
                    @error('name') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">Email</label>
                    <input name="email" type="email" value="{{ old('email', $user->email) }}"
                           class="w-full rounded-2xl border border-ink/10 bg-paper px-4 py-3 outline-none ring-gold/40 focus:ring-2">
                    @error('email') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">Preferred translation</label>
                    <select name="preferred_translation" class="w-full rounded-2xl border border-ink/10 bg-paper px-4 py-3">
                        <option value="hy" @selected(old('preferred_translation', $user->preferred_translation) === 'hy')">Armenian · Հայերեն</option>
                        <option value="ru" @selected(old('preferred_translation', $user->preferred_translation) === 'ru')">Russian · Русский</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">Daily goal (green marks)</label>
                    <input name="daily_goal" type="number" min="5" max="100" value="{{ old('daily_goal', $user->daily_goal) }}"
                           class="w-full rounded-2xl border border-ink/10 bg-paper px-4 py-3 outline-none ring-gold/40 focus:ring-2">
                    @error('daily_goal') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
                </div>
                <button class="rounded-full bg-ink px-6 py-3 font-semibold text-paper">Save changes</button>
            </form>
        </section>

        <div class="space-y-6">
            <section class="rounded-3xl bg-white p-6 shadow-sm">
                <h2 class="font-display text-2xl">Change password</h2>
                <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5">
                    @csrf
                    @method('put')
                    <div>
                        <label class="mb-2 block text-sm font-medium">Current password</label>
                        <input name="current_password" type="password"
                               class="w-full rounded-2xl border border-ink/10 bg-paper px-4 py-3 outline-none ring-gold/40 focus:ring-2">
                        @error('current_password', 'updatePassword') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">New password</label>
                        <input name="password" type="password"
                               class="w-full rounded-2xl border border-ink/10 bg-paper px-4 py-3 outline-none ring-gold/40 focus:ring-2">
                        @error('password', 'updatePassword') <p class="mt-2 text-sm text-clay">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Confirm password</label>
                        <input name="password_confirmation" type="password"
                               class="w-full rounded-2xl border border-ink/10 bg-paper px-4 py-3 outline-none ring-gold/40 focus:ring-2">
                    </div>
                    @if (session('status') === 'password-updated')
                        <div class="rounded-2xl bg-emerald/10 px-4 py-3 text-sm text-emerald">Password updated.</div>
                    @endif
                    <button class="rounded-full bg-ink px-6 py-3 font-semibold text-paper">Update password</button>
                </form>
            </section>

            <section class="rounded-3xl border border-clay/20 bg-white p-6 shadow-sm">
                <h2 class="font-display text-2xl text-clay">Delete account</h2>
                <p class="mt-2 text-sm text-ink/60">This removes your progress and green marks permanently.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6 space-y-4" x-data="{ open: false }">
                    @csrf
                    @method('delete')
                    <input name="password" type="password" placeholder="Current password"
                           class="w-full rounded-2xl border border-ink/10 bg-paper px-4 py-3 outline-none ring-gold/40 focus:ring-2">
                    @error('password', 'userDeletion') <p class="text-sm text-clay">{{ $message }}</p> @enderror
                    <button class="rounded-full bg-clay px-6 py-3 font-semibold text-white">Delete my account</button>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
