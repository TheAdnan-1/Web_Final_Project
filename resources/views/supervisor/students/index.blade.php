@extends('layouts.app')

@section('eyebrow', 'Supervisor')
@section('heading', 'My Students')

@section('content')
    <div class="bg-white rounded-2xl border border-line overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-line text-left text-xs uppercase tracking-wider text-ink/40 font-mono">
                    <th class="px-6 py-4">Student</th>
                    <th class="px-6 py-4">Department</th>
                    <th class="px-6 py-4">Internship</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($students as $student)
                    @php $internship = $student->internships->sortByDesc('start_date')->first(); @endphp
                    <tr class="hover:bg-canvas/60 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-ink/5 flex items-center justify-center text-ink/60 text-xs font-semibold font-mono">
                                    {{ $student->user->initials() }}
                                </div>
                                <div>
                                    <p class="font-medium">{{ $student->user->name }}</p>
                                    <p class="text-xs text-ink/40 font-mono">{{ $student->student_no }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-ink/60">{{ $student->department }}</td>
                        <td class="px-6 py-4 text-ink/60">{{ $internship?->title ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if ($internship)
                                <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-signal-{{ $internship->statusBadgeColor() }}/10 text-signal-{{ $internship->statusBadgeColor() }} capitalize">
                                    {{ $internship->status }}
                                </span>
                            @else
                                <span class="text-xs text-ink/30">No internship yet</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('supervisor.students.show', $student) }}" class="text-accent-ink text-sm font-medium hover:underline">View profile</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-14 text-center text-ink/40">No students assigned to you yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
