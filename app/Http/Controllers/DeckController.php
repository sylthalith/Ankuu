<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeckController extends Controller
{
    public function show()
    {
        return view('decks.show');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);

        Auth::user()->decks()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard');
    }
}
