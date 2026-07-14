@extends('layouts.app')

@section('eyebrow', 'Supervisor')
@section('heading', 'Evaluate ' . $internship->student->user->name)

@section('content')
    <div class="max-w-2xl bg-white rounded-2xl border border-line p-8">
        <form method="POST" action="{{ route('supervisor.evaluations.store', $internship) }}"
              x-data="{
                  scores: { technical_skills: 3, communication: 3, teamwork: 3, punctuality: 3, initiative: 3 },
                  get avg() {
                      const v = Object.values(this.scores);
                      return (v.reduce((a,b) => a + Number(b), 0) / v.length).toFixed(2);
                  }
              }"
              class="space-y-6">
            @csrf

            @foreach (\App\Models\Evaluation::CRITERIA as $key => $label)
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-medium text-ink/70">{{ $label }}</label>
                        <span class="text-sm font-mono text-accent-ink" x-text="scores.{{ $key }} + '/5'"></span>
                    </div>
                    <input type="range" min="1" max="5" name="{{ $key }}" x-model="scores.{{ $key }}"
                           class="w-full h-2 rounded-full appearance-none bg-line accent-accent">
                </div>
            @endforeach

            <div class="rounded-xl bg-canvas p-4 flex items-center justify-between">
                <span class="text-sm text-ink/60">Overall rating (auto-calculated)</span>
                <span class="font-display text-xl font-semibold" x-text="avg"></span>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Evaluation date</label>
                <input type="date" name="evaluation_date" value="{{ old('evaluation_date', now()->format('Y-m-d')) }}" required
                       class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Comments</label>
                <textarea name="comments" rows="4" placeholder="Overall remarks about the intern's performance..."
                          class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">{{ old('comments') }}</textarea>
            </div>

            <button type="submit" class="bg-ink text-white text-sm font-medium px-6 py-3 rounded-xl hover:bg-ink-soft transition">
                Submit evaluation
            </button>
        </form>
    </div>
@endsection
