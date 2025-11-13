<div class="max-w-3xl mx-auto p-6 space-y-6 bg-gray-800/70 text-white rounded-lg">

  {{-- workout title --}}
  <h2 class="text-2xl font-bold">
      <span class="opacity-50 font-normal">Name:</span>  
    {{ $name }}
  </h2>

  {{-- work/rest duration and rounds --}}
  <div class="grid grid-cols-3 gap-4">
    <div>
        <div class="opacity-50 mb-1 italic">Work Duration:</div>
        <div class="bg-gray-700 p-4 py-2 rounded transition duration-500 hover:bg-gray-600">{{ $work }} seconds</div>
    </div>
    <div>
        <div class="opacity-50 mb-1 italic">Rest Duration:</div>
        <div class="bg-gray-700 p-4 py-2 rounded transition duration-500 hover:bg-gray-600">{{ $rest }} seconds</div>
    </div>
    <div>
        <div class="opacity-50 mb-1 italic">Rounds:</div>
        <div class="bg-gray-700 p-4 py-2 rounded transition duration-500 hover:bg-gray-600">{{ $rounds }}</div>
    </div>
  </div>

  {{-- workout contents --}}
  <div>
        <div class="opacity-50 mb-1 italic">Exercises (in one round):</div>
        <div class="bg-gray-700 p-4 rounded w-full transition duration-500 hover:bg-gray-600">
            <ol class="list-decimal list-inside">
                @foreach ($exercises as $index => $ex)
                    <li>{{ $ex }}</lu>
                @endforeach
            </ul>
        </div>
    </div>

  {{-- action btn --}}
  <div class="flex items-end justify-between">
    <a href="/" class="bg-green-500 transition text-gray-900 px-4 py-2 rounded hover:bg-green-600">< Edit</a>
    <div>
        <span class="opacity-50">Total Duration:</span> {{ floor($total_duration/60) }}m {{ floor($total_duration%60) }}s 
    </div>
    <form action="{{ route('workout.begin') }}" method="POST">
        @csrf 
        <input type="hidden" name="">
        <input type="hidden">
        <button type="submit" class="bg-yellow-400 transition text-gray-900 px-4 py-2 rounded hover:bg-yellow-500">Begin ></button>
    </form>
  </div>
</div>