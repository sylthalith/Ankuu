<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    @vite(['resources/js/auth/login.js'])
</head>
<body>

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

</body>
</html>
