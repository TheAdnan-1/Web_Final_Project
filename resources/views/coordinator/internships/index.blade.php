@extends('layouts.app')

@section('eyebrow', 'Coordinator')
@section('heading', 'Internships')

@section('content')
    <form method="GET" class="flex flex-wrap items-center gap-3 mb-6">
        <select name="status" onchange="this.form.submit()" class="rounded-xl border border-line px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50">
            <option value="">All statuses</option>
            @foreach (['pending', 'ongoing', 'completed', 'terminated'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <select name="department" onchange="this.form.submit()" class="rounded-xl border border-line px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50">
            <option value="">All departments</option>
            @foreach ($departments as $dept)
                <option value="{{ $dept }}" @selected(request('department') === $dept)>{{ $dept }}</option>
            @endforeach
        </select>
    </form>

    <div class="bg-white rounded-2xl border border-line overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-line text-left text-xs uppercase tracking-wider text-ink/40 font-mono">
                    <th class="px-6 py-4">Student</th>
                    <th class="px-6 py-4">Company</th>
                    <th class="px-6 py-4">Supervisor</th>
                    <th class="px-6 py-4">Duration</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($internships as $internship)
                    <tr class="hover:bg-canvas/60 transition">
                        <td class="px-6 py-4 font-medium">{{ $internship->student->user->name }}</td>
                        <td class="px-6 py-4 text-ink/60">{{ $internship->company_name }}</td>
                        <td class="px-6 py-4 text-ink/60">{{ $internship->student->supervisor?->user?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-ink/50 font-mono text-xs">{{ $internship->start_date->format('d M') }} - {{ $internship->end_date->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-signal-{{ $internship->statusBadgeColor() }}/10 text-signal-{{ $internship->statusBadgeColor() }} capitalize">
                                {{ $internship->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('coordinator.internships.show', $internship) }}" class="text-accent-ink text-sm font-medium hover:underline">Details</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-14 text-center text-ink/40">No internships match these filters.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $internships->links() }}</div>
    </div>
@endsection
