@php
    $padded_minutes = str_pad(floor($current_workout['total_duration'] / 60), 2, '0', STR_PAD_LEFT);
    $padded_seconds = str_pad(floor($current_workout['total_duration'] % 60), 2, '0', STR_PAD_LEFT);
@endphp

<div class="wrapper max-w-3xl mx-auto transition" 
    data-total-time="{{ $current_workout['total_duration'] }}" 
    data-work-time="{{ $current_workout['work'] }}"
    data-rest-time="{{ $current_workout['rest'] }}"
    data-rounds="{{ $current_workout['rounds'] }}"
    data-exercises="{{ json_encode($current_workout['exercises']) }}"
>
    
    {{-- current round --}}
    <div class="round text-2xl text-center font-semibold mb-7 flex gap-8 justify-center drop-shadow-[0_0_2px_rgba(255,255,255,0.8)]">
        <div class="flex justify-between gap-6 text-[cyan]">
            <span>Round</span>
            <span>
                <span class="current-round">1</span> / {{$current_workout['rounds']}} 
            </span>
        </div>
        <span class="font-normal opacity-60">
            (Total: <span class="total-time">{{ $padded_minutes }}:{{ $padded_seconds }}</span>)
        </span>
    </div>

    {{-- exercises --}}
    <div class="exercises p-6 bg-gray-800/70 text-white rounded-lg mb-7 transition text-[20px]">
        <ol class="list-decimal list-inside leading-[2.5]">
            @foreach ($current_workout['exercises'] as $exercise)
                <li class="exercise font-semibold transition duration-300">{{ $exercise }}</li>
            @endforeach
        </ol>
    </div>

    {{-- Start btn w/ msg --}}
    <div class="flex justify-end gap-4 items-center">
        <span class="message transition py-2 px-3 text-[coral] text-[15px] rounded-md" style="background-color: rgba(0,0,0,0.5);">Once pressed, the workout begins immediately! <b><i>Do not forget to warm up!</i></b></span>
        <button class="start-btn bg-[limegreen] text-gray-900 px-4 py-2 rounded transition hover:opacity-60">Start</button>
    </div>

</div>


{{-- workout timer --}}
<div class="timer w-[460px] h-[200px] fixed top-[100px] right-[20px] transition duration-500 invisible opacity-0 flex flex-col gap-4 text-center font-bold" style="text-shadow: 0 0 4px antiquewhite;">
    <div class="timer-time bg-black/70 rounded-lg border border-2 border-gray-500 text-[140px]">00:00</div>
    <div class="timer-text text-[50px] bg-black/50 rounded-md">Timer Text</div>
</div>