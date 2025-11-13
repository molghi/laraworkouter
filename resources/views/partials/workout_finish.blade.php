@php    
    $workout_data = session('workout_data');
    $real_total_duration_mins = floor($real_total_duration/60);
    $real_total_duration_secs = floor($real_total_duration%60);
@endphp

<div class="max-w-3xl mx-auto grid gap-4 gap-y-6 grid-cols-3 bg-gray-800/70 text-white px-4 py-6 rounded-lg">
  
  <div class="col-span-3 flex items-center gap-4">
    <label class="flex-shrink-0">Workout Name:</label>
    <div class="border border-gray-500 rounded p-2 bg-black flex-grow">{{ $workout_data['name'] }}</div>
  </div>

  <div>
    <label>Work Seconds</label>
    <div class="mt-1 border border-gray-500 rounded p-2 bg-black flex-grow">{{ $workout_data['work'] }}</div>
  </div>
  
  <div>
    <label>Rest Seconds</label>
    <div class="mt-1 border border-gray-500 rounded p-2 bg-black flex-grow">{{ $workout_data['rest'] }}</div>
  </div>
  
  <div>
    <label>Rounds Number</label>
    <div class="mt-1 border border-gray-500 rounded p-2 bg-black flex-grow">{{ $workout_data['rounds'] }}</div>
  </div>

  <div class="col-span-3">
    <label>Exercises</label>
    <div class="mt-1 border border-gray-500 rounded p-4 bg-black flex-grow">
        <ol class="list-decimal list-inside leading-8">
            @foreach ($workout_data['exercises'] as $exercise)
                <li>{{ $exercise }}</li>
            @endforeach
        </ol>
    </div>
  </div>

  <div class="col-span-3 grid grid-cols-2 gap-4">
    <div title="Minutes, seconds">
        <label>Real Total Duration</label>
        <div class="mt-1 border border-gray-500 rounded p-2 bg-black flex-grow">
            {{ str_pad($real_total_duration_mins, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($real_total_duration_secs, 2, '0', STR_PAD_LEFT) }}
        </div>
    </div>
    <div>
        <label>Finished At</label>
        <div class="mt-1 border border-gray-500 rounded p-2 bg-black flex-grow">{{ $finished_at }}</div>
    </div>
</div>


<div class="col-span-3">
    <form action="{{ route('workout.register') }}" method="POST" class="flex flex-col gap-4">
    <div>
        <label>Note (optional)</label>
        <textarea autofocus name="note" class="mt-1 w-full border border-gray-500 rounded p-2 bg-[#1D0035] min-h-[70px] max-h-[300px]"></textarea>
    </div>
        @csrf
        <input type="hidden" name="real_total_duration" value="{{ $real_total_duration }}">
        <input type="hidden" name="finished_at" value="{{ $finished_at }}">
        <div class="text-right">
            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded transition duration-300 hover:opacity-50">Submit Result</button>
        </div>
    </form>
  </div>
</div>
