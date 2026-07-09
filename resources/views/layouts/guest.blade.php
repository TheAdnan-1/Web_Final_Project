<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome') · InternTrack</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

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
                        signal: { blue: '#3E63DD', green: '#1F9D74', red: '#D6455D' },
                    },
                }
            }
        }
    </script>
    <style>
        .grid-texture {
            background-image: linear-gradient(#ffffff0d 1px, transparent 1px), linear-gradient(90deg, #ffffff0d 1px, transparent 1px);
            background-size: 32px 32px;
        }
    </style>
</head>
<body class="h-full font-sans bg-canvas">
<div class="min-h-full grid lg:grid-cols-2">
    {{-- Left: brand panel --}}
    <div class="hidden lg:flex flex-col justify-between bg-ink text-white p-12 relative overflow-hidden grid-texture">
        <div class="relative z-10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-accent flex items-center justify-center text-ink font-display font-bold">IT</div>
            <span class="font-display font-semibold text-xl tracking-tight">InternTrack</span>
        </div>

        <div class="relative z-10 max-w-md">
            <p class="text-[11px] uppercase tracking-[0.2em] text-accent font-mono mb-4">Entry No. 001</p>
            <h2 class="font-display text-4xl font-semibold leading-tight tracking-tight mb-4">
                Every day of the internship, written down and signed off.
            </h2>
            <p class="text-white/50 leading-relaxed">
                Students log their work, supervisors review and evaluate, and coordinators watch every
                department's progress from one place &mdash; no more spreadsheets or paper logbooks.
            </p>
        </div>

        <div class="relative z-10 flex items-center gap-8 text-white/40 text-sm font-mono">
            <span><i class="fa-regular fa-clock mr-1.5"></i>Daily logs</span>
            <span><i class="fa-regular fa-comment mr-1.5"></i>Feedback</span>
            <span><i class="fa-solid fa-chart-line mr-1.5"></i>Evaluation</span>
        </div>
    </div>

    {{-- Right: form panel --}}
    <div class="flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md">
            <div class="lg:hidden flex items-center gap-3 mb-8 justify-center">
                <div class="w-9 h-9 rounded-lg bg-ink flex items-center justify-center text-accent font-display font-bold text-sm">IT</div>
                <span class="font-display font-semibold text-lg tracking-tight text-ink">InternTrack</span>
            </div>
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
