@extends('layouts.app')

@push('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('title')
    <title>Study</title>
@endpush

@push('imports')
    @vite(['resources/js/study.js', 'resources/css/study.css'])
@endpush

@section('content')
    <div id="loading" class="hidden">
        Loading...
    </div>

    <div id="error" class="hidden">

    </div>

    <div id="study-app">
        <pre id="front" class="hidden"></pre>
        <pre id="back" class="hidden"></pre>
        <div id="btns">
            <button id="show" class="hidden">Show answer</button>
            <button id="again" class="hidden"></button>
            <button id="hard" class="hidden"></button>
            <button id="good" class="hidden"></button>
            <button id="easy" class="hidden"></button>
        </div>
    </div>
@endsection
