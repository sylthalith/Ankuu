<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use App\Models\StudySession;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StudyController extends Controller
{
    public function start(Request $request)
    {
        $request->validate([
            'deck_id' => ['required']
        ]);

        $deck = Deck::find($request->deck_id);
        $user = auth()->user();

        $this->deleteOldSession($request->deck_id);

        $cards = Card::where('next_review_date', '<=', Carbon::now()->toDateString())
            ->where('deck_id', $deck->id)
            ->inRandomOrder()
            ->get();

        if ($cards->isEmpty()) {
            return redirect('dashboard');
        }

        $session = $deck->session()->create();

        foreach ($cards as $card) {
            $session->sessionCards()->create([
                'card_id' => $card->id,
            ]);
        }

        dd('done');
    }

    public function next()
    {
        // ...
    }

    public function end()
    {
        // ...
    }

    public function deleteOldSession($deck_id) {
        $unfinished_session = StudySession::where('deck_id', $deck_id)->first();

        if ($unfinished_session) {
            $unfinished_session->delete();
        }
    }
}
