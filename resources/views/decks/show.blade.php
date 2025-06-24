@extends('layouts.app')

@push('title')
    <title>Create deck</title>
@endpush

@push('imports')

@endpush

@section('content')
    <form method="POST" action="{{ route('decks.store') }}">
        @csrf
        <label for="name">Deck name</label>
        <input type="text" name="name" id="name">
        <button type="submit">Create</button>
    </form>
@endsection
