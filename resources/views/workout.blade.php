@php
    $current_workout = session('workout_data');
@endphp

@extends('layouts.app')

@section('title', "Action")

@section('content')
    {{-- page title --}}
    <h1 class="text-3xl font-semibold text-yellow-400 drop-shadow-[0_0_2px_rgba(255,255,150,0.8)] text-center my-10">
        <span class="font-normal opacity-50">Current Workout: </span>
        {{ $current_workout['name'] }}
    </h1>
    {{-- workout block --}}
    @include('partials.workout_block')
@endsection