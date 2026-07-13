@extends('layouts.app')

@section('eyebrow', 'Coordinator')
@section('heading', 'Admin Accounts')

@section('content')
    <div class="rounded-2xl border border-accent/30 bg-accent/10 p-5 mb-6 flex items-start gap-3">
        <i class="fa-solid fa-shield-halved text-accent-ink mt-0.5"></i>
        <p class="text-sm text-ink/70">
            Admins have full access to manage students, supervisors, internships, and other admin
            accounts. Only add people you trust with this level of access.
        </p>
    </div>

    <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name"
                   class="rounded-xl border border-line px-4 py-2.5 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            <button class="text-sm text-ink/50 hover:text-ink px-3"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <a href="{{ route('coordinator.admins.create') }}" class="bg-ink text-white text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-ink-soft transition">
            <i class="fa-solid fa-plus text-xs mr-1.5"></i>Add admin
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-line overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-line text-left text-xs uppercase tracking-wider text-ink/40 font-mono">
                    <th class="px-6 py-4">Admin</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($admins as $admin)
                    <tr class="hover:bg-canvas/60 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-ink/5 flex items-center justify-center text-ink/60 text-xs font-semibold font-mono">
                                    {{ $admin->initials() }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <p class="font-medium">{{ $admin->name }}</p>
                                    @if ($admin->id === auth()->id())
                                        <span class="text-[10px] font-mono px-1.5 py-0.5 rounded-full bg-ink/10 text-ink/50">YOU</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-ink/60">{{ $admin->email }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono px-2.5 py-1 rounded-full {{ $admin->status === 'active' ? 'bg-signal-green/10 text-signal-green' : 'bg-signal-red/10 text-signal-red' }} capitalize">
                                {{ $admin->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-3 whitespace-nowrap">
                            <a href="{{ route('coordinator.admins.edit', $admin) }}" class="text-accent-ink text-sm font-medium hover:underline">Edit</a>
                            @if ($admin->id !== auth()->id())
                                <form method="POST" action="{{ route('coordinator.admins.destroy', $admin) }}" class="inline" onsubmit="return confirm('Remove this admin account?')">
                                    @csrf @method('DELETE')
                                    <button class="text-signal-red text-sm font-medium hover:underline">Remove</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-14 text-center text-ink/40">No admin accounts found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $admins->links() }}</div>
    </div>
@endsection
