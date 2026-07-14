@extends('layouts.app')

@section('eyebrow', 'Student')
@section('heading', $internship ? 'Update internship info' : 'Submit internship info')

@section('content')
    <div class="max-w-2xl bg-white rounded-2xl border border-line p-8">
        <form method="POST" action="{{ $internship ? route('student.internship.update', $internship) : route('student.internship.store') }}" class="space-y-5">
            @csrf
            @if ($internship) @method('PUT') @endif

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Internship title / role</label>
                <input type="text" name="title" value="{{ old('title', $internship->title ?? '') }}" required placeholder="e.g. Software Development Intern"
                       class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Company / organization</label>
                <input type="text" name="company_name" value="{{ old('company_name', $internship->company_name ?? '') }}" required
                       class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Company address</label>
                <textarea name="company_address" rows="2"
                          class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">{{ old('company_address', $internship->company_address ?? '') }}</textarea>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Start date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', optional($internship->start_date ?? null)->format('Y-m-d')) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">End date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', optional($internship->end_date ?? null)->format('Y-m-d')) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Total hours required</label>
                <input type="number" name="total_hours_required" value="{{ old('total_hours_required', $internship->total_hours_required ?? 400) }}" required
                       class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Description</label>
                <textarea name="description" rows="4" placeholder="Briefly describe your role and responsibilities"
                          class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">{{ old('description', $internship->description ?? '') }}</textarea>
            </div>

            <button type="submit" class="bg-ink text-white text-sm font-medium px-6 py-3 rounded-xl hover:bg-ink-soft transition">
                {{ $internship ? 'Save changes' : 'Submit internship info' }}
            </button>
        </form>
    </div>
@endsection
