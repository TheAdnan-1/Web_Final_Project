@extends('layouts.app')

@section('eyebrow', 'Supervisor')
@section('heading', 'Welcome back, ' . explode(' ', auth()->user()->name)[0])

@section('content')
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-2xl border border-line p-5">
            <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Assigned students</p>
            <p class="font-display text-3xl font-semibold">{{ $stats['total_students'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-line p-5">
            <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Ongoing</p>
            <p class="font-display text-3xl font-semibold text-signal-blue">{{ $stats['ongoing'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-line p-5">
            <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Completed</p>
            <p class="font-display text-3xl font-semibold text-signal-green">{{ $stats['completed'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-line p-5">
            <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Pending review</p>
            <p class="font-display text-3xl font-semibold text-accent-ink">{{ $stats['pending_reviews'] }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-line p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display font-semibold text-lg">Logs awaiting review</h2>
                <a href="{{ route('supervisor.logs.index') }}" class="text-sm text-accent-ink font-medium hover:underline">View all</a>
            </div>
            @if ($pendingLogs->isEmpty())
                <p class="text-sm text-ink/40 py-10 text-center">All caught up &mdash; no pending logs.</p>
            @else
                <div class="divide-y divide-line">
                    @foreach ($pendingLogs as $log)
                        <a href="{{ route('supervisor.logs.show', $log) }}" class="flex items-center justify-between py-3.5 group">
                            <div class="min-w-0">
                                <p class="font-medium text-sm truncate group-hover:text-accent-ink transition">{{ $log->title }}</p>
                                <p class="text-xs text-ink/40 mt-0.5">{{ $log->internship->student->user->name }} &middot; {{ $log->log_date->format('d M') }}</p>
                            </div>
                            <i class="fa-solid fa-chevron-right text-xs text-ink/20"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-line p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display font-semibold text-lg">My students</h2>
                <a href="{{ route('supervisor.students.index') }}" class="text-sm text-accent-ink font-medium hover:underline">View all</a>
            </div>
            <div class="space-y-4">
                @foreach ($students->take(5) as $student)
                    <a href="{{ route('supervisor.students.show', $student) }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-full bg-ink/5 flex items-center justify-center text-ink/60 text-xs font-semibold font-mono flex-shrink-0">
                            {{ $student->user->initials() }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium truncate group-hover:text-accent-ink transition">{{ $student->user->name }}</p>
                            <p class="text-xs text-ink/40">{{ $student->department }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
