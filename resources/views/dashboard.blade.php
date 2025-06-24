@extends('layouts.app')

@push('title')
    <title>Ankuu</title>
@endpush

@push('imports')

@endpush

@section('content')
    Dashboard
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
    @if ($decks->isEmpty())
        <p>You have no decks yet. <a href="{{ route('decks.show') }}">Create</a></p>
    @else
        <ul class="decks-content">
            @foreach ($decks as $deck)
                <li class="deck">
                    <form method="POST" action="{{ route('study') }}">
                        @csrf
                        <input type="hidden" name="deck_id" value="{{ $deck->id }}">
                        <button type="submit">{{ $deck->name }}</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
