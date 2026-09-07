<x-auth-layout>
    <h1 class="font-display text-4xl">Verify email</h1>
    <p class="mt-2 text-ink/60">Please confirm your email address. You can keep learning while the link is on the way.</p>

    @if (session('status') === 'verification-link-sent')
        <div class="mt-6 rounded-2xl bg-emerald/10 px-4 py-3 text-sm text-emerald">A new verification link was sent.</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="mt-8">
        @csrf
        <button class="w-full rounded-full bg-ink py-3.5 font-semibold text-paper">Resend verification email</button>
    </form>
    <a href="{{ route('dashboard') }}" class="mt-6 inline-block text-sm font-semibold text-emerald">Continue to dashboard</a>
</x-auth-layout>
