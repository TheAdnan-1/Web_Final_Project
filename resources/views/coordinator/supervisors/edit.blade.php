@extends('layouts.app')

@section('eyebrow', 'Coordinator')
@section('heading', 'Edit Supervisor')

@section('content')
    <div class="max-w-2xl bg-white rounded-2xl border border-line p-8">
        <form method="POST" action="{{ route('coordinator.supervisors.update', $supervisor) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Full name</label>
                    <input type="text" name="name" value="{{ old('name', $supervisor->user->name) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email', $supervisor->user->email) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $supervisor->user->phone) }}"
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Account status</label>
                    <select name="status" class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                        <option value="active" @selected(old('status', $supervisor->user->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $supervisor->user->status) === 'inactive')>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Designation</label>
                    <input type="text" name="designation" value="{{ old('designation', $supervisor->designation) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Department</label>
                    <input type="text" name="department" value="{{ old('department', $supervisor->department) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Company / organization</label>
                <input type="text" name="company_name" value="{{ old('company_name', $supervisor->company_name) }}"
                       class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-ink text-white text-sm font-medium px-6 py-3 rounded-xl hover:bg-ink-soft transition">Save changes</button>
                <a href="{{ route('coordinator.supervisors.index') }}" class="text-sm text-ink/50 hover:text-ink">Cancel</a>
            </div>
        </form>
    </div>
@endsection
