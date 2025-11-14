<div style="flex: 1" class="">
    {{-- title --}}
    <h2 class="text-2xl font-semibold text-snow-400 drop-shadow-[0_0_2px_rgba(255,255,255,0.8)] text-center mb-3">
        Recent Workouts
        {{ !empty($finished_workouts) && count($finished_workouts) > 0 ? '(' . count($finished_workouts) . ')' : '' }}
    </h2>

    @if (!empty($finished_workouts) && count($finished_workouts) > 0)
        <div class="workout-box max-h-[70vh] overflow-y-scroll p-2">
            @foreach ($finished_workouts as $workout)
                <div class="border border-gray-500 rounded-md p-4 mb-6 bg-black/50 transition duration-300 hover:bg-black/80 flex flex-col gap-3">
                    {{-- name --}}
                    <div> <span class="font-bold opacity-50">Name:</span> {{ $workout['name'] }} </div>

                    {{-- work/rest, rounds and total time --}}
                    <div class="flex gap-4 justify-between">
                        <div> <span class="font-bold opacity-50">Work/Rest:</span> {{ $workout['work'] }}/{{ $workout['rest'] }} secs</div>
                        <div> <span class="font-bold opacity-50">Rounds:</span> {{ $workout['rounds'] }} </div>
                        <div title="Minutes, seconds"> 
                            @php
                                $real_total_duration_mins = floor($workout['real_total_duration']/60);
                                $real_total_duration_mins = str_pad($real_total_duration_mins, 2, '0', STR_PAD_LEFT);
                                $real_total_duration_secs = floor($workout['real_total_duration']%60);
                                $real_total_duration_secs = str_pad($real_total_duration_secs, 2, '0', STR_PAD_LEFT);
                            @endphp
                            <span class="font-bold opacity-50">Total Time:</span> {{ $real_total_duration_mins }}:{{ $real_total_duration_secs }}
                        </div>
                    </div>

                    {{-- note --}}
                    @if (!empty($workout['note']) && $workout['note'])
                        <div> <span class="font-bold opacity-50">Note:</span> {{ $workout['note'] }} </div>
                    @endif

                    {{-- exercises toggler and finished at --}}
                    <div class="smaller-container flex gap-4 justify-between">
                        <div> <span class="font-bold opacity-50">Exercises:</span> <button class="toggle-btn underline hover:no-underline">Show</button> </div>
                        <div> <span class="font-bold opacity-50">Finished at:</span> {{ substr($workout['finished_at'], 0, -3) }} </div>
                    </div>

                    {{-- exercises list --}}
                    <ol class="list-decimal list-inside leading-8 ml-4 hidden">
                        @foreach (json_decode($workout['exercises'], true) as $exercise)
                            <li>{{ $exercise }}</li>
                        @endforeach
                    </ol>

                </div>
            @endforeach
        </div>
    @else
        <div class="text-center italic">Finished workouts will be displayed here...</div>
    @endif
</div>



<script>    
    // show/hide exercises list
    document.querySelector('.workout-box').addEventListener('click', function(e) {
        if (!e.target.classList.contains('toggle-btn')) return;
        if (e.target.closest('.smaller-container').nextElementSibling.classList.contains('hidden')) {
            e.target.closest('.smaller-container').nextElementSibling.classList.remove('hidden')
            e.target.textContent = 'Hide';
        } else {
            e.target.closest('.smaller-container').nextElementSibling.classList.add('hidden')
            e.target.textContent = 'Show';
        }
    })
</script>