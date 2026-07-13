@extends('layouts.app')

@section('eyebrow', 'Coordinator')
@section('heading', 'Supervisors')

@section('content')
    <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name"
                   class="rounded-xl border border-line px-4 py-2.5 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            <button class="text-sm text-ink/50 hover:text-ink px-3"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <a href="{{ route('coordinator.supervisors.create') }}" class="bg-ink text-white text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-ink-soft transition">
            <i class="fa-solid fa-plus text-xs mr-1.5"></i>Add supervisor
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-line overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-line text-left text-xs uppercase tracking-wider text-ink/40 font-mono">
                    <th class="px-6 py-4">Supervisor</th>
                    <th class="px-6 py-4">Department</th>
                    <th class="px-6 py-4">Company</th>
                    <th class="px-6 py-4">Students</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($supervisors as $supervisor)
                    <tr class="hover:bg-canvas/60 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-ink/5 flex items-center justify-center text-ink/60 text-xs font-semibold font-mono">
                                    {{ $supervisor->user->initials() }}
                                </div>
                                <div>
                                    <p class="font-medium">{{ $supervisor->user->name }}</p>
                                    <p class="text-xs text-ink/40">{{ $supervisor->designation }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-ink/60">{{ $supervisor->department }}</td>
                        <td class="px-6 py-4 text-ink/60">{{ $supervisor->company_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-ink/60">{{ $supervisor->students->count() }}</td>
                        <td class="px-6 py-4 text-right space-x-3 whitespace-nowrap">
                            <a href="{{ route('coordinator.supervisors.edit', $supervisor) }}" class="text-accent-ink text-sm font-medium hover:underline">Edit</a>
                            <form method="POST" action="{{ route('coordinator.supervisors.destroy', $supervisor) }}" class="inline" onsubmit="return confirm('Remove this supervisor and their account?')">
                                @csrf @method('DELETE')
                                <button class="text-signal-red text-sm font-medium hover:underline">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-14 text-center text-ink/40">No supervisors found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $supervisors->links() }}</div>
    </div>
@endsection
