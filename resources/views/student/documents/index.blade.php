@extends('layouts.app')

@section('eyebrow', 'Student')
@section('heading', 'Supporting Documents')

@section('content')
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-line p-6 h-fit">
            <h2 class="font-display font-semibold mb-4">Upload a document</h2>
            @if (!$internship)
                <p class="text-sm text-ink/40">Submit your internship info first.</p>
            @else
                <form method="POST" action="{{ route('student.documents.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-ink/70 mb-1.5">Title</label>
                        <input type="text" name="title" required placeholder="e.g. Offer letter"
                               class="w-full rounded-xl border border-line px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink/70 mb-1.5">File</label>
                        <input type="file" name="file" required
                               class="w-full text-sm text-ink/60 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-ink file:text-white file:text-sm">
                        <p class="text-xs text-ink/30 mt-1.5">PDF, DOC, DOCX, JPG or PNG · Max 5MB</p>
                    </div>
                    <button type="submit" class="w-full bg-ink text-white text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-ink-soft transition">
                        Upload
                    </button>
                </form>
            @endif
        </div>

        <div class="lg:col-span-2 bg-white rounded-2xl border border-line p-6">
            <h2 class="font-display font-semibold mb-4">Your documents</h2>
            @if ($documents->isEmpty())
                <p class="text-sm text-ink/40 py-10 text-center">No documents uploaded yet.</p>
            @else
                <div class="divide-y divide-line">
                    @foreach ($documents as $doc)
                        <div class="flex items-center justify-between py-3.5">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-lg bg-canvas flex items-center justify-center text-ink/50 flex-shrink-0">
                                    <i class="fa-regular fa-file"></i>
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ $doc->url() }}" target="_blank" class="font-medium text-sm truncate hover:text-accent-ink transition block">{{ $doc->title }}</a>
                                    <p class="text-xs text-ink/40 font-mono">{{ strtoupper($doc->file_type) }} &middot; {{ $doc->humanSize() }}</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('student.documents.destroy', $doc) }}" onsubmit="return confirm('Delete this document?')">
                                @csrf @method('DELETE')
                                <button class="text-ink/30 hover:text-signal-red transition"><i class="fa-regular fa-trash-can"></i></button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
