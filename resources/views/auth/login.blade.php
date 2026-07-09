@extends('layouts.guest')

@section('title', 'Sign in')

@section('content')
    <p class="text-[11px] uppercase tracking-[0.2em] text-accent-ink font-mono mb-2">Welcome back</p>
    <h1 class="font-display text-3xl font-semibold tracking-tight text-ink mb-1">Sign in to InternTrack</h1>
    <p class="text-ink/50 mb-8">Pick up right where your logbook left off.</p>

    @include('partials.alerts')

    <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-ink/70 mb-1.5">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
        </div>

        <div>
            <label class="block text-sm font-medium text-ink/70 mb-1.5">Password</label>
            <input type="password" name="password" required
                   class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
        </div>

        <label class="flex items-center gap-2 text-sm text-ink/60">
            <input type="checkbox" name="remember" class="rounded border-line text-accent focus:ring-accent">
            Remember me
        </label>

        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

        <button type="submit" class="w-full bg-ink text-white rounded-xl py-3 text-sm font-medium hover:bg-ink-soft transition flex items-center justify-center gap-2">
            Sign in <i class="fa-solid fa-arrow-right text-xs"></i>
        </button>
    </form>

    <p class="text-center text-sm text-ink/50 mt-8">
        New to InternTrack?
        <a href="{{ route('register') }}" class="text-accent-ink font-medium hover:underline">Create a student account</a>
    </p>

    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('login-form');
            if (!form) {
                return;
            }

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const tokenInput = document.getElementById('g-recaptcha-response');

                grecaptcha.ready(function () {
                    grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', { action: 'login' }).then(function (token) {
                        tokenInput.value = token;
                        form.submit();
                    });
                });
            });
        });
    </script>

    <!-- <div class="mt-10 pt-6 border-t border-line">
        <p class="text-[11px] uppercase tracking-widest text-ink/30 font-mono mb-2">Demo accounts (password: <span class="text-ink/50">password</span>)</p>
        <ul class="text-xs text-ink/50 space-y-1 font-mono">
            <li>coordinator@interntrack.test</li>
            <li>supervisor1@interntrack.test</li>
            <li>student1@interntrack.test</li>
        </ul>
    </div> -->
@endsection
