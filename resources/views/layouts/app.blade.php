<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · InternTrack</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        ink: { DEFAULT: '#161B2E', soft: '#242C48', faint: '#3A4468' },
                        canvas: '#F3F5F9',
                        line: '#E4E7EF',
                        accent: { DEFAULT: '#E8A33D', dark: '#B87A1E', ink: '#7C4A12' },
                        signal: { blue: '#3E63DD', green: '#1F9D74', red: '#D6455D', amber: '#E8A33D' },
                    },
                    borderRadius: { '2xl': '1.1rem' },
                }
            }
        }
    </script>

    <style>
        body { background-color: #F3F5F9; }
        .timeline-rail { position: relative; }
        .timeline-rail::before {
            content: '';
            position: absolute;
            left: 21px;
            top: 8px;
            bottom: 8px;
            width: 2px;
            background: repeating-linear-gradient(to bottom, #D9DEE9 0, #D9DEE9 6px, transparent 6px, transparent 12px);
        }
        .timeline-node {
            position: relative; z-index: 1;
            width: 44px; height: 44px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            border-radius: 9999px; background: #161B2E; color: #E8A33D;
            font-family: 'JetBrains Mono', monospace; font-size: 11px; border: 3px solid #F3F5F9;
        }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #3A4468; border-radius: 9999px; }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="h-full font-sans text-ink antialiased">
<div class="min-h-full flex" x-data="{ sidebarOpen: false }">

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen=false" class="fixed inset-0 bg-black/40 z-30 lg:hidden"></div>

    {{-- Sidebar --}}
    <aside
        class="fixed lg:static inset-y-0 left-0 z-40 w-72 bg-ink text-white flex flex-col transition-transform duration-200 lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <div class="h-20 flex items-center gap-3 px-6 border-b border-white/10">
            <div class="w-9 h-9 rounded-lg bg-accent flex items-center justify-center text-ink font-display font-bold text-sm">IT</div>
            <div>
                <p class="font-display font-semibold text-lg leading-none tracking-tight">InternTrack</p>
                <p class="text-[11px] text-white/40 font-mono mt-1 uppercase tracking-wider">Logbook &amp; Performance</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto scrollbar-thin px-4 py-6 space-y-6">
            @php $role = auth()->user()->role; @endphp

            @if($role === 'student')
                @include('partials.nav-student')
            @elseif($role === 'supervisor')
                @include('partials.nav-supervisor')
            @elseif($role === 'coordinator')
                @include('partials.nav-coordinator')
            @endif
        </nav>

        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 px-2 py-2 rounded-xl bg-white/5">
                <div class="w-9 h-9 rounded-full bg-accent/20 border border-accent/40 flex items-center justify-center text-accent text-xs font-semibold font-mono">
                    {{ auth()->user()->initials() }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-white/40 capitalize">{{ $role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-white/40 hover:text-accent transition" title="Log out">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0">
        <header class="h-20 bg-white border-b border-line flex items-center justify-between px-6 lg:px-10 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden text-ink/70"><i class="fa-solid fa-bars text-lg"></i></button>
                <div>
                    <p class="text-[11px] uppercase tracking-widest text-ink/40 font-mono">@yield('eyebrow', 'Overview')</p>
                    <h1 class="font-display text-xl md:text-2xl font-semibold tracking-tight">@yield('heading', 'Dashboard')</h1>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('profile.edit') }}" class="hidden sm:flex items-center gap-2 text-sm text-ink/60 hover:text-ink transition">
                    <i class="fa-regular fa-user"></i> Profile
                </a>
            </div>
        </header>

        <main class="flex-1 px-6 lg:px-10 py-8">
            @include('partials.alerts')
            @yield('content')
        </main>

        <footer class="px-6 lg:px-10 py-6 text-xs text-ink/40 font-mono">
            InternTrack &middot; Internship Logbook &amp; Performance Management System
        </footer>
    </div>
</div>
@stack('scripts')
</body>
</html>
