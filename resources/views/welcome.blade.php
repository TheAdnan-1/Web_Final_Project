<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InternTrack &middot; Internship Logbook &amp; Performance Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: {
                    display: ['Space Grotesk', 'sans-serif'],
                    sans: ['Inter', 'sans-serif'],
                    mono: ['JetBrains Mono', 'monospace'],
                },
                colors: {
                    ink: { DEFAULT: '#161B2E', soft: '#242C48' },
                    canvas: '#F3F5F9',
                    line: '#E4E7EF',
                    accent: { DEFAULT: '#E8A33D', ink: '#7C4A12' },
                    signal: { blue: '#3E63DD', green: '#1F9D74', red: '#D6455D' },
                },
            } }
        }
    </script>
    <style>
        .grid-texture {
            background-image: linear-gradient(#ffffff0d 1px, transparent 1px), linear-gradient(90deg, #ffffff0d 1px, transparent 1px);
            background-size: 36px 36px;
        }
    </style>
</head>
<body class="bg-canvas font-sans text-ink antialiased">

    {{-- Nav --}}
    <header class="max-w-7xl mx-auto px-6 lg:px-10 py-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-ink flex items-center justify-center text-accent font-display font-bold text-sm">IT</div>
            <span class="font-display font-semibold text-lg tracking-tight">InternTrack</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-sm font-medium text-ink/60 hover:text-ink px-4 py-2">Sign in</a>
            <a href="{{ route('register') }}" class="text-sm font-medium bg-ink text-white px-5 py-2.5 rounded-xl hover:bg-ink-soft transition">Get started</a>
        </div>
    </header>

    {{-- Hero --}}
    <section class="bg-ink text-white grid-texture relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-20 lg:py-28 grid lg:grid-cols-2 gap-16 items-center relative z-10">
            <div>
                <p class="text-[11px] uppercase tracking-[0.25em] text-accent font-mono mb-5">Entry No. 001 &middot; Internship Logbook</p>
                <h1 class="font-display text-4xl sm:text-5xl font-semibold leading-[1.1] tracking-tight mb-6">
                    Every internship day, logged, reviewed, and signed off — in one place.
                </h1>
                <p class="text-white/50 text-lg leading-relaxed mb-10 max-w-lg">
                    InternTrack replaces the paper logbook with a shared record students, supervisors and
                    coordinators can all trust — daily activity, feedback, evaluations, and reports, all tied together.
                </p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('register') }}" class="bg-accent text-ink font-medium px-6 py-3.5 rounded-xl hover:bg-accent/90 transition">
                        Start your logbook
                    </a>
                    <a href="{{ route('login') }}" class="text-white/70 font-medium px-6 py-3.5 rounded-xl border border-white/15 hover:border-white/30 transition">
                        Sign in
                    </a>
                </div>
            </div>

            {{-- Signature: logbook entry card --}}
            <div class="bg-white text-ink rounded-2xl p-6 shadow-2xl rotate-1 max-w-sm mx-auto w-full">
                <div class="flex items-center justify-between text-xs font-mono text-ink/40 mb-4 pb-4 border-b border-line">
                    <span>LOG &middot; WEEK 06</span>
                    <span>12 JUL 2026</span>
                </div>
                <p class="font-medium mb-1">Integrated payment gateway</p>
                <p class="text-sm text-ink/50 leading-relaxed mb-4">Completed sandbox testing for the checkout flow and documented edge cases for the QA handoff.</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-mono text-ink/40"><i class="fa-regular fa-clock mr-1"></i>6.5 hrs</span>
                    <span class="text-xs font-mono px-2 py-1 rounded-full bg-signal-green/10 text-signal-green">Reviewed</span>
                </div>
                <div class="mt-4 pt-4 border-t border-line flex items-center gap-1 text-accent text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    <span class="text-ink/40 ml-2 font-mono">— F. Kabir, Supervisor</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Three modules --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-10 py-20">
        <p class="text-[11px] uppercase tracking-[0.25em] text-accent-ink font-mono mb-3">Three roles, one record</p>
        <h2 class="font-display text-3xl font-semibold tracking-tight mb-14 max-w-xl">Built around how internships actually run.</h2>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border border-line p-8">
                <div class="w-11 h-11 rounded-xl bg-accent/10 flex items-center justify-center text-accent-ink mb-6">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <h3 class="font-display font-semibold text-lg mb-2">Students</h3>
                <p class="text-sm text-ink/55 leading-relaxed mb-4">Submit internship details, write daily or weekly logs, attach supporting documents, and generate a final report.</p>
                <ul class="text-sm text-ink/50 space-y-1.5 font-mono">
                    <li><i class="fa-solid fa-check text-signal-green mr-2 text-xs"></i>Logbook entries</li>
                    <li><i class="fa-solid fa-check text-signal-green mr-2 text-xs"></i>Document uploads</li>
                    <li><i class="fa-solid fa-check text-signal-green mr-2 text-xs"></i>Feedback inbox</li>
                </ul>
            </div>
            <div class="bg-white rounded-2xl border border-line p-8">
                <div class="w-11 h-11 rounded-xl bg-signal-blue/10 flex items-center justify-center text-signal-blue mb-6">
                    <i class="fa-solid fa-people-arrows"></i>
                </div>
                <h3 class="font-display font-semibold text-lg mb-2">Supervisors</h3>
                <p class="text-sm text-ink/55 leading-relaxed mb-4">Review submitted logs, leave structured feedback, and evaluate performance across five clear criteria.</p>
                <ul class="text-sm text-ink/50 space-y-1.5 font-mono">
                    <li><i class="fa-solid fa-check text-signal-green mr-2 text-xs"></i>Log review queue</li>
                    <li><i class="fa-solid fa-check text-signal-green mr-2 text-xs"></i>Rated feedback</li>
                    <li><i class="fa-solid fa-check text-signal-green mr-2 text-xs"></i>Final evaluations</li>
                </ul>
            </div>
            <div class="bg-white rounded-2xl border border-line p-8">
                <div class="w-11 h-11 rounded-xl bg-signal-green/10 flex items-center justify-center text-signal-green mb-6">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <h3 class="font-display font-semibold text-lg mb-2">Coordinators</h3>
                <p class="text-sm text-ink/55 leading-relaxed mb-4">Manage every student and supervisor record, assign mentors, and monitor department-wide completion at a glance.</p>
                <ul class="text-sm text-ink/50 space-y-1.5 font-mono">
                    <li><i class="fa-solid fa-check text-signal-green mr-2 text-xs"></i>Supervisor assignment</li>
                    <li><i class="fa-solid fa-check text-signal-green mr-2 text-xs"></i>Live analytics</li>
                    <li><i class="fa-solid fa-check text-signal-green mr-2 text-xs"></i>Department reports</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-10 pb-24">
        <div class="bg-ink text-white rounded-2xl p-12 text-center grid-texture">
            <h2 class="font-display text-2xl sm:text-3xl font-semibold tracking-tight mb-3">Ready to close the paper logbook for good?</h2>
            <p class="text-white/50 mb-8 max-w-lg mx-auto">Create your account and start your first entry today.</p>
            <a href="{{ route('register') }}" class="inline-block bg-accent text-ink font-medium px-7 py-3.5 rounded-xl hover:bg-accent/90 transition">
                Create free account
            </a>
        </div>
    </section>

    <footer class="max-w-7xl mx-auto px-6 lg:px-10 pb-10 text-xs text-ink/35 font-mono flex items-center justify-between">
        <span>InternTrack &middot; Internship Logbook &amp; Performance Management System</span>
        <span>Final Year Laravel Project</span>
    </footer>
</body>
</html>
