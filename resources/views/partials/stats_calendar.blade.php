@php
    $month_names = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    $weekday_names = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

    $month_now = date('m');
    $this_month_last_day = date('d', strtotime('last day of this month'));
    $this_month_start = date('w', strtotime('first day of this month')); // offset
    $day_now = date('d');
@endphp


<div style="flex: 0 1 33%">
    {{-- title --}}
    <h2 class="text-2xl font-semibold text-snow-400 drop-shadow-[0_0_2px_rgba(255,255,255,0.8)] text-center mb-5">Workouts in {{ $month_names[$month_now-1] }}</h2>

    {{-- month --}}
    <div class="flex flex-wrap mb-8" >
        {{-- print weekday names --}}
        @for($i = 0; $i < count($weekday_names); $i++)
            <div class="border border-white text-center py-2 bg-black/40" style="flex: 0 1 calc(100%/7)">{{ substr($weekday_names[$i], 0, 3) }}</div>
        @endfor
        {{-- print offset days --}}
        @for($i = 0; $i < $this_month_start; $i++)
            <div class="border border-white text-center py-2 bg-black/40 opacity-30" style="flex: 0 1 calc(100%/7)"></div>
        @endfor
        {{-- print real days --}}
        @for($i = 0; $i < $this_month_last_day; $i++)
            <div class="border border-white text-center py-2 bg-black/40 
                    {{ $i+1 < $day_now ? 'opacity-30' : '' }}
                    " 
                style="flex: 0 1 calc(100%/7)">{{ $i+1 }}</div>
        @endfor
    </div>

    {{-- frequency --}}
    <div class="text-center">
        <span class="font-bold opacity-50">Worked out:</span> 0 out of {{ $this_month_last_day }} days
    </div>
</div>