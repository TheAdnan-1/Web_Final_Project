@extends('layouts.app')

@section('eyebrow', 'Student · Log entry')
@section('heading', $log->title)

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="bg-white rounded-2xl border border-line p-8">
            <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
                <div class="flex items-center gap-3 text-sm text-ink/50 font-mono">
                    <span><i class="fa-regular fa-calendar mr-1.5"></i>{{ $log->log_date->format('d M Y') }}</span>
                    <span><i class="fa-regular fa-clock mr-1.5"></i>{{ $log->hours_spent }} hours</span>
                </div>
                <span class="text-xs font-mono px-2.5 py-1 rounded-full {{ $log->status === 'reviewed' ? 'bg-signal-green/10 text-signal-green' : 'bg-accent/10 text-accent-ink' }}">
                    {{ ucfirst($log->status) }}
                </span>
            </div>
            <p class="text-ink/70 leading-relaxed whitespace-pre-line">{{ $log->description }}</p>

            @if ($log->documents->isNotEmpty())
                <div class="mt-6 pt-6 border-t border-line">
                    <p class="text-xs uppercase tracking-widest text-ink/40 font-mono mb-3">Attachments</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($log->documents as $doc)
                            <a href="{{ $doc->url() }}" target="_blank" class="text-sm px-3 py-1.5 rounded-lg bg-canvas border border-line hover:border-accent transition">
                                <i class="fa-regular fa-file mr-1.5"></i>{{ $doc->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if ($log->feedback)
            <div class="bg-white rounded-2xl border border-line p-8">
                <p class="text-xs uppercase tracking-widest text-ink/40 font-mono mb-4">Supervisor feedback</p>
                <div class="flex items-center gap-1 text-accent mb-3">
                    @for ($i = 0; $i < 5; $i++)
                        <i class="fa-solid fa-star text-xs {{ $i < $log->feedback->rating ? '' : 'text-line' }}"></i>
                    @endfor
                </div>
                <p class="text-ink/70 leading-relaxed">{{ $log->feedback->comment }}</p>
                <p class="text-sm text-ink/40 mt-4">— {{ $log->feedback->supervisor->user->name }}</p>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-line p-8 text-center text-sm text-ink/40">
                Awaiting supervisor review.
            </div>
        @endif

        <a href="{{ route('student.logs.index') }}" class="inline-flex items-center gap-2 text-sm text-ink/50 hover:text-ink">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to all logs
        </a>
    </div>
@endsection
