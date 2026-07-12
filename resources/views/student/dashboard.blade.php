@extends('layouts.app')

@section('eyebrow', 'Student')
@section('heading', 'Welcome back, ' . explode(' ', auth()->user()->name)[0])

@section('content')

    @if (!$internship)
        <div class="rounded-2xl border border-accent/30 bg-accent/10 p-6 flex items-center justify-between flex-wrap gap-4">
            <div>
                <p class="font-display font-semibold text-lg text-ink">You haven't submitted your internship details yet</p>
                <p class="text-sm text-ink/60 mt-1">Add your company, role, and duration to start your logbook.</p>
            </div>
            <a href="{{ route('student.internship.create') }}" class="bg-ink text-white text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-ink-soft transition whitespace-nowrap">
                Submit internship info
            </a>
        </div>
    @else
        {{-- Stat row --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-2xl border border-line p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-ink/40 uppercase tracking-wider font-mono">Status</p>
                    <a href="{{ route('student.internship.create') }}" class="text-ink/30 hover:text-accent-ink transition" title="Edit internship info"><i class="fa-solid fa-pen text-xs"></i></a>
                </div>
                <span class="inline-flex items-center gap-1.5 text-sm font-medium px-2.5 py-1 rounded-full bg-signal-{{ $internship->statusBadgeColor() }}/10 text-signal-{{ $internship->statusBadgeColor() }} capitalize">
                    <i class="fa-solid fa-circle text-[6px]"></i>{{ $internship->status }}
                </span>
                <p class="text-sm text-ink/50 mt-3">{{ $internship->company_name }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-line p-5">
                <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Hours logged</p>
                <p class="font-display text-2xl font-semibold">{{ number_format($internship->totalHoursLogged(), 1) }} <span class="text-sm text-ink/40 font-sans">/ {{ $internship->total_hours_required }}</span></p>
                <div class="mt-3 h-2 rounded-full bg-line overflow-hidden">
                    <div class="h-full bg-accent rounded-full" style="width: {{ $internship->progressPercent() }}%"></div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-line p-5">
                <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Supervisor</p>
                <p class="font-display font-semibold">{{ $student->supervisor?->user?->name ?? 'Not yet assigned' }}</p>
                <p class="text-sm text-ink/50 mt-1">{{ $student->supervisor?->designation ?? '—' }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-line p-5">
                <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Duration</p>
                <p class="text-sm font-medium">{{ $internship->start_date->format('d M Y') }}</p>
                <p class="text-sm text-ink/50">to {{ $internship->end_date->format('d M Y') }}</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Recent logs timeline --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-line p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-display font-semibold text-lg">Recent log entries</h2>
                    <a href="{{ route('student.logs.create') }}" class="text-sm text-accent-ink font-medium hover:underline"><i class="fa-solid fa-plus text-xs mr-1"></i>New entry</a>
                </div>

                @if ($recentLogs->isEmpty())
                    <p class="text-sm text-ink/40 py-8 text-center">No log entries yet. Your logbook starts with the first one.</p>
                @else
                    <div class="timeline-rail space-y-6">
                        @foreach ($recentLogs as $log)
                            <div class="flex gap-4">
                                <div class="timeline-node">{{ $log->log_date->format('d/m') }}</div>
                                <a href="{{ route('student.logs.show', $log) }}" class="flex-1 pt-1.5 group">
                                    <p class="font-medium group-hover:text-accent-ink transition">{{ $log->title }}</p>
                                    <p class="text-sm text-ink/50 line-clamp-1 mt-0.5">{{ $log->description }}</p>
                                    <p class="text-xs text-ink/30 font-mono mt-1">{{ $log->hours_spent }}h logged &middot; {{ ucfirst($log->status) }}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Feedback --}}
            <div class="bg-white rounded-2xl border border-line p-6">
                <h2 class="font-display font-semibold text-lg mb-6">Latest feedback</h2>
                @if ($recentFeedback->isEmpty())
                    <p class="text-sm text-ink/40 py-8 text-center">No supervisor feedback yet.</p>
                @else
                    <div class="space-y-5">
                        @foreach ($recentFeedback as $feedback)
                            <div class="pb-5 border-b border-line last:border-0 last:pb-0">
                                <div class="flex items-center gap-1 text-accent mb-1.5">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="fa-solid fa-star text-[10px] {{ $i < $feedback->rating ? '' : 'text-line' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-sm text-ink/70">{{ $feedback->comment }}</p>
                                <p class="text-xs text-ink/30 mt-2 font-mono">— {{ $feedback->supervisor->user->name }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
