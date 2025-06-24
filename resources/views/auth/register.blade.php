@extends('layouts.app')

@push('title')
    <title>Ankuu</title>
@endpush

@push('imports')

@endpush

@section('content')
    <a href="{{ route('welcome') }}">Welcome</a>
    <a href="{{ route('login') }}">Login</a>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <label for="name">Name</label>
        <input type="text" id="name" name="name">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
        <label for="password_confirmation">Confirm password</label>
        <input type="password" id="password_confirmation" name="password_confirmation">
        <button type="submit">Register</button>
    </form>
@endsection
