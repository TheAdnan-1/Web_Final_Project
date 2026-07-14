@extends('layouts.app')

@section('eyebrow', 'Supervisor · Student profile')
@section('heading', $student->user->name)

@section('content')
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            @if ($internship)
                <div class="bg-white rounded-2xl border border-line p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-display font-semibold text-lg">{{ $internship->title }}</h2>
                        <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-signal-{{ $internship->statusBadgeColor() }}/10 text-signal-{{ $internship->statusBadgeColor() }} capitalize">
                            {{ $internship->status }}
                        </span>
                    </div>
                    <p class="text-sm text-ink/60">{{ $internship->company_name }} &middot; {{ $internship->start_date->format('d M Y') }} - {{ $internship->end_date->format('d M Y') }}</p>
                    <div class="mt-4 h-2 rounded-full bg-line overflow-hidden">
                        <div class="h-full bg-accent rounded-full" style="width: {{ $internship->progressPercent() }}%"></div>
                    </div>
                    <p class="text-xs text-ink/40 mt-2 font-mono">{{ number_format($internship->totalHoursLogged(), 1) }} / {{ $internship->total_hours_required }} hours logged</p>

                    <a href="{{ route('supervisor.evaluations.create', $internship) }}" class="inline-flex items-center gap-2 mt-5 bg-ink text-white text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-ink-soft transition">
                        <i class="fa-solid fa-star text-xs"></i> Evaluate performance
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-line p-6">
                    <h2 class="font-display font-semibold text-lg mb-5">Log entries</h2>
                    @if ($logs->isEmpty())
                        <p class="text-sm text-ink/40 py-8 text-center">No log entries submitted yet.</p>
                    @else
                        <div class="timeline-rail space-y-6">
                            @foreach ($logs as $log)
                                <div class="flex gap-4">
                                    <div class="timeline-node">{{ $log->log_date->format('d/m') }}</div>
                                    <a href="{{ route('supervisor.logs.show', $log) }}" class="flex-1 pt-1.5 group">
                                        <p class="font-medium group-hover:text-accent-ink transition">{{ $log->title }}</p>
                                        <p class="text-sm text-ink/50 line-clamp-1 mt-0.5">{{ $log->description }}</p>
                                        <p class="text-xs {{ $log->status === 'reviewed' ? 'text-signal-green' : 'text-accent-ink' }} font-mono mt-1">{{ ucfirst($log->status) }}</p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="bg-white rounded-2xl border border-line p-10 text-center text-ink/40">
                    This student hasn't submitted internship information yet.
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-line p-6">
                <p class="text-xs uppercase tracking-widest text-ink/40 font-mono mb-3">Student details</p>
                <p class="font-medium">{{ $student->user->name }}</p>
                <p class="text-sm text-ink/50">{{ $student->student_no }}</p>
                <div class="mt-4 space-y-2 text-sm text-ink/60">
                    <p><i class="fa-regular fa-envelope w-4 text-ink/30"></i> {{ $student->user->email }}</p>
                    <p><i class="fa-solid fa-building-columns w-4 text-ink/30"></i> {{ $student->department }}</p>
                    <p><i class="fa-solid fa-graduation-cap w-4 text-ink/30"></i> {{ $student->program }}</p>
                </div>
            </div>

            @if ($documents->isNotEmpty())
                <div class="bg-white rounded-2xl border border-line p-6">
                    <p class="text-xs uppercase tracking-widest text-ink/40 font-mono mb-3">Documents</p>
                    <div class="space-y-2">
                        @foreach ($documents as $doc)
                            <a href="{{ $doc->url() }}" target="_blank" class="flex items-center gap-2 text-sm text-ink/60 hover:text-accent-ink transition">
                                <i class="fa-regular fa-file"></i> {{ $doc->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($evaluations->isNotEmpty())
                <div class="bg-white rounded-2xl border border-line p-6">
                    <p class="text-xs uppercase tracking-widest text-ink/40 font-mono mb-3">Past evaluations</p>
                    @foreach ($evaluations as $ev)
                        <div class="flex items-center justify-between py-2 border-b border-line last:border-0">
                            <span class="text-sm text-ink/60">{{ $ev->evaluation_date->format('d M Y') }}</span>
                            <span class="font-display font-semibold">{{ $ev->overall_rating }}/5</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
