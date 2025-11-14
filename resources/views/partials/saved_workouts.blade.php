<div class="max-w-5xl mx-auto grid grid-cols-3 gap-6 items-start">
    @if (!empty($finished_workouts) && count($finished_workouts) > 0)
        @foreach ($finished_workouts as $workout)
            <div class="workout bg-black/50 text-center border rounded-md border-gray-500 p-4 pb-5 flex flex-col gap-4 transition duration-300 hover:bg-black/80">
                {{-- name --}}
                <div> <span class="font-bold italic opacity-50">Name:</span> {{ $workout['name'] }} </div>

                {{-- work/rest and rounds --}}
                <div class="flex gap-4 justify-between text-sm">
                    <div> <span class="font-bold italic opacity-50">Work/Rest:</span> {{ $workout['work'] }}/{{ $workout['rest'] }} secs</div>
                    <div> <span class="font-bold italic opacity-50">Rounds:</span> {{ $workout['rounds'] }} </div>
                </div>

                {{-- exercises list --}}
                <div class="text-left">
                    <div> <span class="font-bold italic opacity-50">Exercises:</span></div>
                    <ol class="list-decimal list-inside leading-8 ml-4">
                        @foreach (json_decode($workout['exercises'], true) as $exercise)
                            <li>{{ $exercise }}</li>
                        @endforeach
                    </ol>
                </div>

                {{-- last done and total time --}}
                <div class="flex gap-4 justify-between text-sm">
                    @php
                        $real_total_duration_mins = floor($workout['real_total_duration']/60);
                        $real_total_duration_mins = str_pad($real_total_duration_mins, 2, '0', STR_PAD_LEFT);
                        $real_total_duration_secs = floor($workout['real_total_duration']%60);
                        $real_total_duration_secs = str_pad($real_total_duration_secs, 2, '0', STR_PAD_LEFT);
                        $how_many_days_ago = floor((time() - strtotime($workout['finished_at']))/60/60/24);
                    @endphp
                    <div title="{{ substr($workout['finished_at'], 0, -3) }} — Days ago: {{ $how_many_days_ago }}"> <span class="font-bold italic opacity-50">Last Done:</span> {{ substr($workout['finished_at'], 0, 10) }} </div>
                    <div title="Time it took in minutes, seconds"> <span class="font-bold italic opacity-50">Time:</span> {{ $real_total_duration_mins }}:{{ $real_total_duration_secs }} </div>
                </div>

                {{-- form & button --}}
                <form action="{{ route('workout.select') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $workout['id'] }}">
                    <button type="submit" title="Do this workout once again" class="bg-green-700 text-white px-4 py-2 rounded transition duration-300 hover:opacity-50">Select</button>
                </form>
            </div>
        @endforeach
    @else
        <div class="text-center italic border rounded-md border-gray-500">Workouts you start will be displayed here...</div>
    @endif
</div>