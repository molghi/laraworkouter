@extends('layouts.app')

@section('title', "Personal Statistics")

@section('content')
    {{-- page title --}}
    <h1 class="text-3xl font-semibold text-yellow-400 drop-shadow-[0_0_2px_rgba(255,255,150,0.8)] text-center my-10">Personal Statistics</h1>

    <div class="max-w-5xl mx-auto flex items-start gap-[70px]">
        @include('partials.stats_calendar')
        @include('partials.stats_workouts')
    </div>
@endsection