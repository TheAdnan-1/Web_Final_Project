@extends('layouts.app')

@section('eyebrow', 'Coordinator')
@section('heading', 'Program Overview')

@section('content')
    <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-8">
        <div class="bg-white rounded-2xl border border-line p-5">
            <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Students</p>
            <p class="font-display text-3xl font-semibold">{{ $stats['students'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-line p-5">
            <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Supervisors</p>
            <p class="font-display text-3xl font-semibold">{{ $stats['supervisors'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-line p-5">
            <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Ongoing</p>
            <p class="font-display text-3xl font-semibold text-signal-blue">{{ $stats['ongoing'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-line p-5">
            <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Completed</p>
            <p class="font-display text-3xl font-semibold text-signal-green">{{ $stats['completed'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-line p-5">
            <p class="text-xs text-ink/40 uppercase tracking-wider font-mono mb-2">Pending</p>
            <p class="font-display text-3xl font-semibold text-accent-ink">{{ $stats['pending'] }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-line p-6">
            <h2 class="font-display font-semibold text-lg mb-4">Students by department</h2>
            <canvas id="deptChart" height="110"></canvas>
        </div>
        <div class="bg-white rounded-2xl border border-line p-6">
            <h2 class="font-display font-semibold text-lg mb-4">Internship status</h2>
            <canvas id="statusChart" height="180"></canvas>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-line p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-display font-semibold text-lg">Recent internships</h2>
                <a href="{{ route('coordinator.internships.index') }}" class="text-sm text-accent-ink font-medium hover:underline">View all</a>
            </div>
            <div class="divide-y divide-line">
                @forelse ($recentInternships as $internship)
                    <div class="flex items-center justify-between py-3.5">
                        <div>
                            <p class="text-sm font-medium">{{ $internship->student->user->name }}</p>
                            <p class="text-xs text-ink/40 mt-0.5">{{ $internship->company_name }}</p>
                        </div>
                        <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-signal-{{ $internship->statusBadgeColor() }}/10 text-signal-{{ $internship->statusBadgeColor() }} capitalize">
                            {{ $internship->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-ink/40 py-8 text-center">No internships recorded yet.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-line p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-display font-semibold text-lg">Students without a supervisor</h2>
                <a href="{{ route('coordinator.students.index') }}" class="text-sm text-accent-ink font-medium hover:underline">Manage</a>
            </div>
            <div class="divide-y divide-line">
                @forelse ($unassignedStudents as $student)
                    <div class="flex items-center justify-between py-3.5">
                        <div>
                            <p class="text-sm font-medium">{{ $student->user->name }}</p>
                            <p class="text-xs text-ink/40 mt-0.5">{{ $student->department }}</p>
                        </div>
                        <a href="{{ route('coordinator.students.edit', $student) }}" class="text-xs text-accent-ink font-medium hover:underline">Assign</a>
                    </div>
                @empty
                    <p class="text-sm text-ink/40 py-8 text-center">Every student has a supervisor. Nice.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const deptCtx = document.getElementById('deptChart');
    new Chart(deptCtx, {
        type: 'bar',
        data: {
            labels: @json($departmentStats->pluck('department')),
            datasets: [{
                label: 'Students',
                data: @json($departmentStats->pluck('total')),
                backgroundColor: '#E8A33D',
                borderRadius: 8,
                maxBarThickness: 42,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#E4E7EF' }, ticks: { precision: 0 } },
                x: { grid: { display: false } }
            }
        }
    });

    const statusCtx = document.getElementById('statusChart');
    const statusColors = { pending: '#E8A33D', ongoing: '#3E63DD', completed: '#1F9D74', terminated: '#D6455D' };
    const statusData = @json($statusStats);
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusData.map(s => s.status.charAt(0).toUpperCase() + s.status.slice(1)),
            datasets: [{
                data: statusData.map(s => s.total),
                backgroundColor: statusData.map(s => statusColors[s.status] || '#161B2E'),
                borderWidth: 0,
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { family: 'Inter' } } } },
            cutout: '65%',
        }
    });
</script>
@endpush
