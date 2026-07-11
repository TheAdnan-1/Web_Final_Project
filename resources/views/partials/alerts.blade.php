@if (session('status'))
    <div class="mb-6 flex items-center gap-3 rounded-2xl border border-signal-green/30 bg-signal-green/10 px-5 py-3.5 text-sm text-emerald-800">
        <i class="fa-solid fa-circle-check text-signal-green"></i>
        <span>{{ session('status') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-signal-red/30 bg-signal-red/10 px-5 py-3.5 text-sm text-rose-800">
        <p class="flex items-center gap-2 font-medium mb-1"><i class="fa-solid fa-triangle-exclamation text-signal-red"></i> Please fix the following:</p>
        <ul class="list-disc list-inside space-y-0.5 ml-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
