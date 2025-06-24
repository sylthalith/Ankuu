<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function show()
    {
        $decks = auth()->user()->decks()->get();

        return view('cards.show', compact('decks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deck_id' => ['required'],
            'front' => ['required'],
            'back' => ['required'],
        ]);

        $deck = Deck::find($request->deck_id);

        $deck->cards()->create([
            'front' => $request->front,
            'back' => $request->back,
            'next_review_date' => Carbon::now()->toDateString(),
        ]);

        session(['lastSelectedDeckId' => $request['deck_id']]);

        return redirect()->route('dashboard');
    }
}
