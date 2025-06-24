@extends('layouts.app')

@push('title')
    <title>Login</title>
@endpush

@push('imports')

@endpush

@section('content')
    <a href="{{ route('welcome') }}">Welcome</a>
    <a href="{{ route('register') }}">Register</a>

    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <label for="name">Name</label>
        <input type="text" id="name" name="name">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
        <button type="submit" id="login-btn">Login</button>
    </form>
@endsection
