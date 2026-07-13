@extends('layouts.app')

@section('eyebrow', 'Coordinator · Internship')
@section('heading', $internship->student->user->name . '’s internship')

@section('content')
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-line p-6">
                <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
                    <h2 class="font-display font-semibold text-lg">{{ $internship->title }}</h2>
                    <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-signal-{{ $internship->statusBadgeColor() }}/10 text-signal-{{ $internship->statusBadgeColor() }} capitalize">
                        {{ $internship->status }}
                    </span>
                </div>
                <p class="text-sm text-ink/60">{{ $internship->company_name }}</p>
                <p class="text-sm text-ink/50">{{ $internship->company_address }}</p>
                <p class="text-sm text-ink/50 mt-1">{{ $internship->start_date->format('d M Y') }} &ndash; {{ $internship->end_date->format('d M Y') }}</p>

                <div class="mt-4 h-2 rounded-full bg-line overflow-hidden">
                    <div class="h-full bg-accent rounded-full" style="width: {{ $internship->progressPercent() }}%"></div>
                </div>
                <p class="text-xs text-ink/40 mt-2 font-mono">{{ number_format($internship->totalHoursLogged(), 1) }} / {{ $internship->total_hours_required }} hours logged</p>

                <form method="POST" action="{{ route('coordinator.internships.update', $internship) }}" class="mt-6 flex items-center gap-3">
                    @csrf @method('PUT')
                    <select name="status" class="rounded-xl border border-line px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50">
                        @foreach (['pending', 'ongoing', 'completed', 'terminated'] as $s)
                            <option value="{{ $s }}" @selected($internship->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-ink text-white text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-ink-soft transition">Update status</button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-line p-6">
                <h2 class="font-display font-semibold text-lg mb-5">Log entries ({{ $internship->activityLogs->count() }})</h2>
                @if ($internship->activityLogs->isEmpty())
                    <p class="text-sm text-ink/40 py-8 text-center">No log entries yet.</p>
                @else
                    <div class="timeline-rail space-y-6">
                        @foreach ($internship->activityLogs->sortByDesc('log_date') as $log)
                            <div class="flex gap-4">
                                <div class="timeline-node">{{ $log->log_date->format('d/m') }}</div>
                                <div class="flex-1 pt-1.5">
                                    <p class="font-medium">{{ $log->title }}</p>
                                    <p class="text-sm text-ink/50 line-clamp-1 mt-0.5">{{ $log->description }}</p>
                                    <p class="text-xs {{ $log->status === 'reviewed' ? 'text-signal-green' : 'text-accent-ink' }} font-mono mt-1">{{ ucfirst($log->status) }} &middot; {{ $log->hours_spent }}h</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-line p-6">
                <p class="text-xs uppercase tracking-widest text-ink/40 font-mono mb-3">Student</p>
                <p class="font-medium">{{ $internship->student->user->name }}</p>
                <p class="text-sm text-ink/50">{{ $internship->student->student_no }} &middot; {{ $internship->student->department }}</p>
                <p class="text-sm text-ink/50 mt-2"><i class="fa-regular fa-envelope w-4 text-ink/30"></i> {{ $internship->student->user->email }}</p>
            </div>

            <div class="bg-white rounded-2xl border border-line p-6">
                <p class="text-xs uppercase tracking-widest text-ink/40 font-mono mb-3">Supervisor</p>
                @if ($internship->student->supervisor)
                    <p class="font-medium">{{ $internship->student->supervisor->user->name }}</p>
                    <p class="text-sm text-ink/50">{{ $internship->student->supervisor->designation }}</p>
                @else
                    <p class="text-sm text-ink/40">Not yet assigned</p>
                @endif
            </div>

            @if ($internship->evaluations->isNotEmpty())
                <div class="bg-white rounded-2xl border border-line p-6">
                    <p class="text-xs uppercase tracking-widest text-ink/40 font-mono mb-3">Evaluations</p>
                    @foreach ($internship->evaluations as $ev)
                        <div class="flex items-center justify-between py-2 border-b border-line last:border-0">
                            <span class="text-sm text-ink/60">{{ $ev->evaluation_date->format('d M Y') }}</span>
                            <span class="font-display font-semibold">{{ $ev->overall_rating }}/5</span>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($internship->documents->isNotEmpty())
                <div class="bg-white rounded-2xl border border-line p-6">
                    <p class="text-xs uppercase tracking-widest text-ink/40 font-mono mb-3">Documents</p>
                    @foreach ($internship->documents as $doc)
                        <a href="{{ $doc->url() }}" target="_blank" class="flex items-center gap-2 text-sm text-ink/60 hover:text-accent-ink transition py-1">
                            <i class="fa-regular fa-file"></i> {{ $doc->title }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
