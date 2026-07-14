@extends('layouts.app')

@section('eyebrow', 'Student')
@section('heading', 'New Log Entry')

@section('content')
    <div class="max-w-2xl bg-white rounded-2xl border border-line p-8">
        <form method="POST" action="{{ route('student.logs.store') }}" class="space-y-5">
            @csrf

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Date</label>
                    <input type="date" name="log_date" value="{{ old('log_date', now()->format('Y-m-d')) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Hours spent</label>
                    <input type="number" step="0.5" name="hours_spent" value="{{ old('hours_spent') }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Implemented login module"
                       class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">What did you work on?</label>
                <textarea name="description" rows="6" required placeholder="Describe tasks completed, challenges faced, and what you learned..."
                          class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-ink text-white text-sm font-medium px-6 py-3 rounded-xl hover:bg-ink-soft transition">
                    Save entry
                </button>
                <a href="{{ route('student.logs.index') }}" class="text-sm text-ink/50 hover:text-ink">Cancel</a>
            </div>
        </form>
    </div>
@endsection
