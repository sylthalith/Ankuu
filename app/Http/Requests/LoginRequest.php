<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate()
    {
        $credentials = $this->validate($this->rules());

        if (Auth::attempt($credentials, $this->boolean('remember'))) {
            $this->session()->regenerate();
            return redirect()->route('decks');
        }

        return back()->withErrors([
            'email' => 'Неверные учетные данные'
        ]);
    }
}
