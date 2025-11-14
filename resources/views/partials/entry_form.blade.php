@php
    $fields = [
        'textarea' => ['workout', 'Your Workout', 'Your workout here: each exercise on a new line'],
        'input1' => ['work', 'Exercise duration (secs)', 'e.g., 30'],
        'input2' => ['rest', 'Rest duration (secs)', 'e.g., 60'],
        'input3' => ['rounds', 'How many rounds', 'e.g., 3'],
        'input4' => ['name', 'Give it a name', 'e.g., Home Workout 1'],
    ];

    $old_form_data = [
        'workout' => '',
        'work' => '',
        'rest' => '',
        'rounds' => '',
        'name' => '',
    ];

     if (session('old_form_data') && session('last_set') === date('Y-m-d')) {
        $old_form_data['workout'] = session('old_form_data')['workout'];
        $old_form_data['work'] = session('old_form_data')['work'];
        $old_form_data['rest'] = session('old_form_data')['rest'];
        $old_form_data['rounds'] = session('old_form_data')['rounds'];
        $old_form_data['name'] = session('old_form_data')['name'];
     }

    $mode = 'default';
    if (!empty($workout)) {
        $mode = 'prefill';
        $workout['exercises'] = implode('', json_decode($workout['exercises'], true)); // format it for textarea
    }
@endphp



<div class="max-w-3xl mx-auto">
  <form action="{{ route('workout.preview') }}" method="POST" class="bg-gray-800/70 text-white px-4 py-6 rounded-lg flex flex-col gap-6" data-workouts="{{  $mode === 'default' ? $saved_workouts : '' }}">
    @csrf 

    <div class="grid grid-cols-4 gap-4">
        @foreach ($fields as $key => $field)
            <div class="{{ $key === 'textarea' ? 'col-span-4' : 'col-span-2' }} flex flex-col gap-1">
                <label for="{{ $field[0] }}" class="opacity-50 text-sm italic">{{ $field[1] }}</label>
                @if ($key === 'textarea')
                    <textarea required 
                        name="{{ $field[0] }}" 
                        id="{{ $field[0] }}" 
                        placeholder="{{ $field[2] }}" 
                        autofocus
                        class="w-full min-h-[150px] max-h-[400px] p-2 rounded bg-[#111] transition focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:bg-gray-900">{{ $mode === 'default' ? $old_form_data[$field[0]] : $workout['exercises'] }}</textarea>
                @else
                    <input required 
                        name="{{ $field[0] }}" 
                        id="{{ $field[0] }}" 
                        type="{{ $field[0] === 'name' ? 'text' : 'number' }}" 
                        min="1" 
                        placeholder="{{ $field[2] }}" 
                        value="{{ $mode === 'default' ? $old_form_data[$field[0]] : $workout[$field[0]] }}"
                        class="flex-1 p-2 rounded bg-[#111] transition focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:bg-gray-900">
                @endif
            </div>
        @endforeach 
    </div>

    <div class="text-right">
      <button class="bg-yellow-400 text-gray-900 px-4 py-2 rounded hover:bg-yellow-500">Submit</button>
    </div>
  </form>



  {{-- to select from Saved Workouts --}}
  @if ($mode === 'default')
    <div class="mt-6 flex gap-6 items-center">
        <button class="pre-fill flex-shrink-0 bg-blue-800 text-gray-900 px-4 py-2 rounded opacity-40 transition duration-300 hover:opacity-100 active:opacity-50 text-white">Pre-fill from Saved Workouts</button>
        <select class="hidden rounded bg-[#222] flex-shrink w-full px-4 py-2 opacity-40 transition duration-300 hover:opacity-100">
            <option selected disabled value="0">Select Saved Workout</option>
            @foreach ($saved_workouts as $saved)
                <option 
                    title="Work/Rest: {{$saved['work']}}/{{$saved['rest']}}. Rounds: {{$saved['rounds']}}.&#10;Exercises: {{ implode('  ', json_decode($saved['exercises'], true)) }}" 
                    value="{{ $saved['id'] }}">
                        {{ $saved['name'] }} -> 
                        {{ substr(implode(', ', json_decode($saved['exercises'], true)), 0, 39) }}
                        {{ strlen(implode(', ', json_decode($saved['exercises'], true))) > 39 ? '...' : '' }}
                </option>
            @endforeach
        </select>
    </div>
  @endif



  {{-- print errors --}}
  @error ('workout')
    <div class="text-[red] p-2 px-4 border border-[red] rounded-md mt-5 error-msg">{{ $message }}</div>
  @enderror

  @error ('work')
    <div class="text-[red] p-2 px-4 border border-[red] rounded-md mt-5 error-msg">{{ $message }}</div>
  @enderror

  @error ('rest')
    <div class="text-[red] p-2 px-4 border border-[red] rounded-md mt-5 error-msg">{{ $message }}</div>
  @enderror

  @error ('rounds')
    <div class="text-[red] p-2 px-4 border border-[red] rounded-md mt-5 error-msg">{{ $message }}</div>
  @enderror

  @error ('name')
    <div class="text-[red] p-2 px-4 border border-[red] rounded-md mt-5 error-msg">{{ $message }}</div>
  @enderror
</div>




<script>
    // remove error msgs after 7 secs
    if (document.querySelector('.error-msg')) {
        setTimeout(() => {
            document.querySelectorAll('.error-msg').forEach(x => x.remove());
        }, 7000);
    }

    // make select visible
    if (document.querySelector('.pre-fill')) {
        document.querySelector('.pre-fill').addEventListener('click', function(e) {
            e.target.nextElementSibling.classList.remove('hidden');
        })
    }
    
    // select option and pre-fill form
    if (document.querySelector('select')) {
        document.querySelector('select').addEventListener('change', function(e) {
            fillForm(e.target.value);
        })
    }

    function fillForm (workoutId) {
        const savedWorkouts = JSON.parse(document.querySelector('form').dataset.workouts);
        const workout = savedWorkouts.find(x => +x.id === +workoutId);
        document.querySelector('textarea').value = workout.workout;
        document.querySelector('input[name="work"]').value = workout.work;
        document.querySelector('input[name="rest"]').value = workout.rest;
        document.querySelector('input[name="rounds"]').value = workout.rounds;
        document.querySelector('input[name="name"]').value = workout.name;
        document.querySelector('textarea').focus();
    }
</script>