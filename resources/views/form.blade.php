@extends('layouts.app')

@section('title', "Form")

@section('content')
    {{-- page title --}}
    <h1 class="text-3xl font-semibold text-yellow-400 drop-shadow-[0_0_2px_rgba(255,255,150,0.8)] text-center my-10">Workout Entry Form</h1>
    {{-- entry form --}}
    @include('partials.entry_form')
@endsection