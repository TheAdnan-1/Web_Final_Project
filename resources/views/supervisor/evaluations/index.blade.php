@extends('layouts.app')

@section('eyebrow', 'Supervisor')
@section('heading', 'Evaluations')

@section('content')
    <div class="bg-white rounded-2xl border border-line overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-line text-left text-xs uppercase tracking-wider text-ink/40 font-mono">
                    <th class="px-6 py-4">Student</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Overall rating</th>
                    <th class="px-6 py-4">Comments</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($evaluations as $ev)
                    <tr class="hover:bg-canvas/60 transition">
                        <td class="px-6 py-4 font-medium">{{ $ev->internship->student->user->name }}</td>
                        <td class="px-6 py-4 text-ink/50 font-mono">{{ $ev->evaluation_date->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="font-display font-semibold">{{ $ev->overall_rating }}</span><span class="text-ink/40">/5</span>
                        </td>
                        <td class="px-6 py-4 text-ink/60 max-w-sm truncate">{{ $ev->comments }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-14 text-center text-ink/40">No evaluations submitted yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $evaluations->links() }}</div>
    </div>
@endsection
