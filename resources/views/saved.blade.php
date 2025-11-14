@extends('layouts.app')

@section('title', "Saved Routines")

@section('content')
    {{-- page title --}}
    <h1 class="text-3xl font-semibold text-yellow-400 drop-shadow-[0_0_2px_rgba(255,255,150,0.8)] text-center my-10">
        Saved Routines
        {{ !empty($finished_workouts) && count($finished_workouts) > 0 ? '(' . count($finished_workouts) . ')' : '' }}
    </h1>

    @include('partials.saved_workouts')
@endsection