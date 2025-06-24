@extends('layouts.app')

@push('title')
    <title>Ankuu</title>
@endpush

@push('imports')

@endpush

@section('content')
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Register</a>
@endsection
