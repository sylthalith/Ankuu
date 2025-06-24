@extends('layouts.app')

@push('title')
    <title>Create card</title>
@endpush

@push('imports')

@endpush

@section('content')
    <form method="POST" action="{{ route('cards.store') }}">
        @csrf
        <label for="deck_id">Deck</label>
        <select name="deck_id" id="deck_id">
            @foreach($decks as $deck)
                @if(session('lastSelectedDeckId') == $deck->id)
                    <option value="{{ $deck->id }}" selected>{{ $deck->name }}</option>
                @else
                    <option value="{{ $deck->id }}">{{ $deck->name }}</option>
                @endif
            @endforeach
        </select>
        <label for="front">Front</label>
        <input type="text" name="front" id="front">
        <label for="back">Back</label>
        <input type="text" name="back" id="back">
        <button type="submit">Create</button>
    </form>
@endsection
