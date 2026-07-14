@extends('layouts.app')

@section('eyebrow', 'Supervisor')
@section('heading', 'Review Logs')

@section('content')
    <div class="flex items-center gap-2 mb-6">
        @foreach (['pending' => 'Pending', 'reviewed' => 'Reviewed', 'all' => 'All'] as $key => $label)
            <a href="{{ route('supervisor.logs.index', ['status' => $key]) }}"
               class="text-sm px-4 py-2 rounded-xl border transition {{ $status === $key ? 'bg-ink text-white border-ink' : 'border-line text-ink/60 hover:border-ink/30' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-line overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-line text-left text-xs uppercase tracking-wider text-ink/40 font-mono">
                    <th class="px-6 py-4">Student</th>
                    <th class="px-6 py-4">Log</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Hours</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($logs as $log)
                    <tr class="hover:bg-canvas/60 transition">
                        <td class="px-6 py-4 font-medium">{{ $log->internship->student->user->name }}</td>
                        <td class="px-6 py-4 text-ink/60 max-w-xs truncate">{{ $log->title }}</td>
                        <td class="px-6 py-4 text-ink/50 font-mono">{{ $log->log_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-ink/50 font-mono">{{ $log->hours_spent }}h</td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono px-2.5 py-1 rounded-full {{ $log->status === 'reviewed' ? 'bg-signal-green/10 text-signal-green' : 'bg-accent/10 text-accent-ink' }}">
                                {{ ucfirst($log->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('supervisor.logs.show', $log) }}" class="text-accent-ink text-sm font-medium hover:underline">
                                {{ $log->status === 'pending' ? 'Review' : 'View' }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-14 text-center text-ink/40">No logs found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $logs->links() }}</div>
    </div>
@endsection
