@extends('layouts.app')

@section('eyebrow', 'Supervisor · Log entry')
@section('heading', $log->title)

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="bg-white rounded-2xl border border-line p-8">
            <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                <div>
                    <p class="font-medium">{{ $log->internship->student->user->name }}</p>
                    <p class="text-xs text-ink/40 font-mono mt-0.5">{{ $log->log_date->format('d M Y') }} &middot; {{ $log->hours_spent }} hours</p>
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

        <div class="bg-white rounded-2xl border border-line p-8">
            <p class="text-xs uppercase tracking-widest text-ink/40 font-mono mb-4">
                {{ $log->feedback ? 'Update your feedback' : 'Leave feedback' }}
            </p>
            <form method="POST" action="{{ route('supervisor.logs.feedback', $log) }}" x-data="{ rating: {{ old('rating', $log->feedback->rating ?? 4) }} }" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-2">Rating</label>
                    <div class="flex items-center gap-1">
                        <template x-for="i in 5" :key="i">
                            <button type="button" @click="rating = i" class="text-2xl transition" :class="i <= rating ? 'text-accent' : 'text-line'">
                                <i class="fa-solid fa-star"></i>
                            </button>
                        </template>
                        <input type="hidden" name="rating" x-model="rating">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Comment</label>
                    <textarea name="comment" rows="4" required placeholder="Share feedback on this entry..."
                              class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">{{ old('comment', $log->feedback->comment ?? '') }}</textarea>
                </div>
                <button type="submit" class="bg-ink text-white text-sm font-medium px-6 py-3 rounded-xl hover:bg-ink-soft transition">
                    {{ $log->feedback ? 'Update feedback' : 'Submit feedback & mark reviewed' }}
                </button>
            </form>
        </div>

        <a href="{{ route('supervisor.logs.index') }}" class="inline-flex items-center gap-2 text-sm text-ink/50 hover:text-ink">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to logs
        </a>
    </div>
@endsection
