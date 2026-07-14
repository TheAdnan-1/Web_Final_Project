@extends('layouts.app')

@section('eyebrow', 'Student')
@section('heading', 'Activity Logs')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-ink/50">Your daily/weekly internship logbook entries.</p>
        <a href="{{ route('student.logs.create') }}" class="bg-ink text-white text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-ink-soft transition">
            <i class="fa-solid fa-plus text-xs mr-1.5"></i>Add log entry
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-line p-6 sm:p-8">
        @if (!$internship)
            <p class="text-sm text-ink/40 py-10 text-center">Submit your internship info first to start logging.</p>
        @elseif ($logs->isEmpty())
            <p class="text-sm text-ink/40 py-10 text-center">No entries yet &mdash; write your first logbook entry.</p>
        @else
            <div class="timeline-rail space-y-8">
                @foreach ($logs as $log)
                    <div class="flex gap-4">
                        <div class="timeline-node">{{ $log->log_date->format('d/m') }}</div>
                        <div class="flex-1 pt-1 pb-2 border-b border-line last:border-0">
                            <div class="flex items-start justify-between gap-3 flex-wrap">
                                <a href="{{ route('student.logs.show', $log) }}" class="font-medium hover:text-accent-ink transition">{{ $log->title }}</a>
                                <span class="text-xs font-mono px-2 py-0.5 rounded-full {{ $log->status === 'reviewed' ? 'bg-signal-green/10 text-signal-green' : 'bg-accent/10 text-accent-ink' }}">
                                    {{ ucfirst($log->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-ink/60 mt-1.5 line-clamp-2">{{ $log->description }}</p>
                            <div class="flex items-center gap-4 mt-2.5 text-xs text-ink/40 font-mono">
                                <span><i class="fa-regular fa-clock mr-1"></i>{{ $log->hours_spent }}h</span>
                                @if ($log->documents_count)
                                    <span><i class="fa-solid fa-paperclip mr-1"></i>{{ $log->documents_count }} file(s)</span>
                                @endif
                                @if ($log->feedback)
                                    <span class="text-signal-green"><i class="fa-regular fa-comment-dots mr-1"></i>Feedback received</span>
                                @endif
                                @if ($log->status === 'pending')
                                    <a href="{{ route('student.logs.edit', $log) }}" class="text-accent-ink hover:underline ml-auto">Edit</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $logs->links() }}</div>
        @endif
    </div>
@endsection
