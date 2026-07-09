@extends('layouts.guest')

@section('title', 'Create account')

@section('content')
    <p class="text-[11px] uppercase tracking-[0.2em] text-accent-ink font-mono mb-2">Get started</p>
    <h1 class="font-display text-3xl font-semibold tracking-tight text-ink mb-1">Create your student account</h1>
    <p class="text-ink/50 mb-6">
        Self-registration is for students. Supervisor and admin accounts are
        created by your coordinator — see the note below.
    </p>

    @include('partials.alerts')

    <form id="register-form" method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Full name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-ink/70 mb-1.5">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Password</label>
                <input type="password" name="password" required
                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Confirm password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Student ID</label>
                <input type="text" name="student_no" value="{{ old('student_no') }}" required
                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Department</label>
                <input type="text" name="department" value="{{ old('department') }}" required placeholder="e.g. Computer Science"
                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Program</label>
                <input type="text" name="program" value="{{ old('program') }}" required placeholder="e.g. BSc in CSE"
                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Semester</label>
                <input type="text" name="semester" value="{{ old('semester') }}"
                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>
        </div>

        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

        <button type="submit" class="w-full bg-ink text-white rounded-xl py-3 text-sm font-medium hover:bg-ink-soft transition">
            Create account
        </button>
    </form>

    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('register-form');
            if (!form) {
                return;
            }

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const tokenInput = document.getElementById('g-recaptcha-response');

                grecaptcha.ready(function () {
                    grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', { action: 'register' }).then(function (token) {
                        tokenInput.value = token;
                        form.submit();
                    });
                });
            });
        });
    </script>

    <div class="mt-8 rounded-xl bg-canvas border border-line px-4 py-3.5 text-sm text-ink/60 flex items-start gap-2.5">
        <i class="fa-solid fa-circle-info text-ink/30 mt-0.5"></i>
        <span>Are you a supervisor? Your coordinator sets up supervisor accounts directly, so your access matches your organization's records. Contact them to get one created.</span>
    </div>

    <p class="text-center text-sm text-ink/50 mt-6">
        Already have an account?
        <a href="{{ route('login') }}" class="text-accent-ink font-medium hover:underline">Sign in</a>
    </p>
@endsection
