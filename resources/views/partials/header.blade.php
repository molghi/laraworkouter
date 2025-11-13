<header class="bg-gray-900/80 text-yellow-400 text-2xl font-mono py-5 px-2 tracking-widest uppercase">
    <div class="flex items-center justify-between max-w-5xl mx-auto">

        <div class="transition opacity-50 hover:opacity-100">{{ $site_name }}</div>

        {{-- header buttons --}}
        <div class="flex items-center gap-5 text-[16px]">
            <a href="/" title="Add New Workout" class="bg-green-400 transition opacity-50 hover:opacity-100 text-gray-900 px-4 py-1 rounded hover:bg-green-500">New</a>
            <a href="/saved" title="View Saved Workouts" class="bg-blue-400 transition opacity-50 hover:opacity-100 text-gray-900 px-4 py-1 rounded hover:bg-blue-500">Saved</a>
            <a href="/stats" title="View Personal Statistics" class="bg-yellow-400 transition opacity-50 hover:opacity-100 text-gray-900 px-4 py-1 rounded hover:bg-yellow-500">Stats</a>
        </div>
    </div>
</header>

{{-- drop-shadow-[0_0_8px_rgba(255,255,150,0.8)] --}}