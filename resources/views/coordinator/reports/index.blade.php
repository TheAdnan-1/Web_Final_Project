@extends('layouts.app')

@section('eyebrow', 'Coordinator')
@section('heading', 'Department Reports')

@section('content')
    <div class="flex justify-end mb-4 no-print">
        <button onclick="window.print()" class="text-sm text-ink/50 hover:text-ink border border-line rounded-xl px-4 py-2">
            <i class="fa-solid fa-print mr-1.5"></i> Print report
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-line overflow-hidden mb-6">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-line text-left text-xs uppercase tracking-wider text-ink/40 font-mono">
                    <th class="px-6 py-4">Department</th>
                    <th class="px-6 py-4">Students</th>
                    <th class="px-6 py-4">Ongoing</th>
                    <th class="px-6 py-4">Completed</th>
                    <th class="px-6 py-4">Avg. rating</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($departmentBreakdown as $row)
                    <tr class="hover:bg-canvas/60 transition">
                        <td class="px-6 py-4 font-medium">{{ $row->department }}</td>
                        <td class="px-6 py-4 text-ink/60">{{ $row->total_students }}</td>
                        <td class="px-6 py-4 text-signal-blue font-medium">{{ $row->ongoing }}</td>
                        <td class="px-6 py-4 text-signal-green font-medium">{{ $row->completed }}</td>
                        <td class="px-6 py-4 font-mono">{{ $row->avg_rating ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-14 text-center text-ink/40">No data yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-2xl border border-line p-6">
        <h2 class="font-display font-semibold text-lg mb-5">Top performing interns</h2>
        @if ($topPerformers->isEmpty())
            <p class="text-sm text-ink/40 py-8 text-center">No evaluations submitted yet.</p>
        @else
            <div class="divide-y divide-line">
                @foreach ($topPerformers as $ev)
                    <div class="flex items-center justify-between py-3.5">
                        <div>
                            <p class="text-sm font-medium">{{ $ev->internship->student->user->name }}</p>
                            <p class="text-xs text-ink/40 mt-0.5">{{ $ev->internship->student->department }}</p>
                        </div>
                        <div class="flex items-center gap-1 text-accent">
                            <span class="font-display font-semibold text-ink mr-1">{{ $ev->overall_rating }}</span>
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fa-solid fa-star text-xs {{ $i < round($ev->overall_rating) ? '' : 'text-line' }}"></i>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
