@extends('layouts.app')

@section('eyebrow', 'Coordinator')
@section('heading', 'Add Student')

@section('content')
    <div class="max-w-2xl bg-white rounded-2xl border border-line p-8">
        <form method="POST" action="{{ route('coordinator.students.store') }}" class="space-y-5">
            @csrf

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Full name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Student ID</label>
                    <input type="text" name="student_no" value="{{ old('student_no') }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink/70 mb-1.5">Temporary password</label>
                <input type="text" name="password" value="{{ old('password') }}" required
                       class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
            </div>

            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Department</label>
                    <input type="text" name="department" value="{{ old('department') }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Program</label>
                    <input type="text" name="program" value="{{ old('program') }}" required
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink/70 mb-1.5">Semester</label>
                    <input type="text" name="semester" value="{{ old('semester') }}"
                           class="w-full rounded-xl border border-line px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-ink text-white text-sm font-medium px-6 py-3 rounded-xl hover:bg-ink-soft transition">Add student</button>
                <a href="{{ route('coordinator.students.index') }}" class="text-sm text-ink/50 hover:text-ink">Cancel</a>
            </div>
        </form>
    </div>
@endsection
