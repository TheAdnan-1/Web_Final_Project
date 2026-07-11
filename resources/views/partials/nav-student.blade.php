@php
    $links = [
        ['route' => 'dashboard', 'icon' => 'fa-gauge', 'label' => 'Dashboard'],
        ['route' => 'student.logs.index', 'icon' => 'fa-book-open', 'label' => 'Activity Logs'],
        ['route' => 'student.documents.index', 'icon' => 'fa-paperclip', 'label' => 'Documents'],
        ['route' => 'student.report.index', 'icon' => 'fa-file-lines', 'label' => 'Internship Report'],
    ];
@endphp

<div>
    <p class="px-3 mb-2 text-[11px] uppercase tracking-widest text-white/30 font-mono">Student</p>
    <div class="space-y-1">
        @foreach ($links as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition
                      {{ request()->routeIs($link['route']) || ($link['route'] === 'student.logs.index' && request()->routeIs('student.logs.*'))
                         ? 'bg-white/10 text-white font-medium' : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid {{ $link['icon'] }} w-4 text-center {{ request()->routeIs($link['route']) ? 'text-accent' : '' }}"></i>
                {{ $link['label'] }}
            </a>
        @endforeach
    </div>
</div>
