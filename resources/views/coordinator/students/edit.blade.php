@extends('layouts.app')

@section('eyebrow', 'Coordinator')
@section('heading', 'Edit Student')

@section('content')
    <div class="max-w-2xl bg-white rounded-2xl border border-line p-8">
        <form method="POST" action="{{ route('coordinator.students.update', $student) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Full name</label>
                    <input type="text" name="name" value="{{ old('name', $student->user->name) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email', $student->user->email) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $student->user->phone) }}"
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Account status</label>
                    <select name="status" class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                        <option value="active" @selected(old('status', $student->user->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $student->user->status) === 'inactive')>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Department</label>
                    <input type="text" name="department" value="{{ old('department', $student->department) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Program</label>
                    <input type="text" name="program" value="{{ old('program', $student->program) }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Semester</label>
                    <input type="text" name="semester" value="{{ old('semester', $student->semester) }}"
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Assigned supervisor</label>
                <select name="supervisor_id" class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                    <option value="">— Not assigned —</option>
                    @foreach ($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}" @selected(old('supervisor_id', $student->supervisor_id) == $supervisor->id)>
                            {{ $supervisor->user->name }} ({{ $supervisor->department }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-ink text-white text-sm font-medium px-6 py-3 rounded-xl hover:bg-ink-soft transition">Save changes</button>
                <a href="{{ route('coordinator.students.index') }}" class="text-sm text-ink/50 hover:text-ink">Cancel</a>
            </div>
        </form>
    </div>
@endsection
