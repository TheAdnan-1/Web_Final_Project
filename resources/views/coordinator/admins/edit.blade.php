@extends('layouts.app')

@section('eyebrow', 'Coordinator')
@section('heading', 'Edit Admin Account')

@section('content')
    <div class="max-w-2xl bg-white rounded-2xl border border-line p-8">
        @if ($admin->id === auth()->id())
            <div class="rounded-xl bg-canvas px-4 py-3 text-sm text-ink/60 mb-6">
                <i class="fa-solid fa-circle-info mr-1.5"></i> This is your own account — you can't deactivate it here.
            </div>
        @endif

        <form method="POST" action="{{ route('coordinator.admins.update', $admin) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Full name</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}"
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Account status</label>
                    <select name="status" {{ $admin->id === auth()->id() ? 'disabled' : '' }}
                            class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent disabled:bg-canvas disabled:text-ink/40">
                        <option value="active" @selected(old('status', $admin->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $admin->status) === 'inactive')>Inactive</option>
                    </select>
                    @if ($admin->id === auth()->id())
                        <input type="hidden" name="status" value="active">
                    @endif
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Reset password <span class="text-ink/40 font-normal">(leave blank to keep current password)</span></label>
                <input type="text" name="password"
                       class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-ink text-white text-sm font-medium px-6 py-3 rounded-xl hover:bg-ink-soft transition">Save changes</button>
                <a href="{{ route('coordinator.admins.index') }}" class="text-sm text-ink/50 hover:text-ink">Cancel</a>
            </div>
        </form>
    </div>
@endsection
