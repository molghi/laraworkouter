@php
    $current_workout = session('workout_data');
@endphp

@extends('layouts.app')

@section('title', "Action")

@section('content')
    {{-- page title --}}
    <h1 class="text-3xl font-semibold text-yellow-400 drop-shadow-[0_0_2px_rgba(255,255,150,0.8)] text-center mt-10 mb-7 transition">
        <span class="font-normal opacity-50">Current Workout: </span>
        <span class="underline">{{ $current_workout['name'] }}</span>
    </h1>
    {{-- workout block --}}
    @include('partials.workout_block')

    {{-- execute workout functionality --}}
    @include('partials.js_execute_workout')
@endsection