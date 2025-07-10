<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use App\Models\SessionCard;
use App\Models\StudySession;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class StudyController extends Controller
{
    public function start(Request $request)
    {
        $request->validate([
            'deck_id' => ['required']
        ]);

        $deck = Deck::find($request->deck_id);
        $user = auth()->user();

        $cards = Card::where('next_review_date', '<=', Carbon::now()->toDateString())
            ->where('deck_id', $deck->id)
            ->inRandomOrder()
            ->get();

        if ($cards->isEmpty()) {
            return redirect('dashboard');
        }

        $this->deleteOldSession($request->deck_id);

        $session = $deck->session()->create();

        session(['current_session_id' => $session->id]);

        foreach ($cards as $card) {
            $session->sessionCards()->create([
                'card_id' => $card->id,
            ]);
        }

        return view('study.show');
    }

    public function answer(Request $request)
    {
        Log::info('answer start: ' . microtime(true));
        $response = response()->json(['success' => true]);
        Log::info('answer end: ' . microtime(true));
        return $response;
    }

    public function next()
    {
        Log::info('next start: ' . microtime(true));
        $response = response()->json([
            'session_card_id' => rand(1, 100),
            'front' => rand(1, 100),
            'back' => rand(1, 100),
            'intervals' => rand(1, 100),
            'end' => false,
        ], 200);
        Log::info('next end: ' . microtime(true));
        return $response;
    }

//    public function next()
//    {
//        return response()->json([
//            'session_card_id' => rand(1, 100),
//            'front' => rand(1, 100),
//            'back' => rand(1, 100),
//            'intervals' => rand(1, 100),
//            'end' => false,
//        ], 200);
//        $session_id = session('current_session_id');
//        $lastSessionCardId = session('lastSessionCardId');
//
//        $query = SessionCard::where('study_session_id', $session_id)->where('retry_later', 1);
//
//        if ($lastSessionCardId) {
//            $query->where('id', '!=', $lastSessionCardId);
//        }
//
//        $session_card = $query->inRandomOrder()->first();
//
//        if (!$session_card) {
//            $query = SessionCard::where('study_session_id', $session_id)->where('retry_later', 1);
//            $session_card = $query->inRandomOrder()->first();
//        }
//
//        if (!$session_card) {
//            session()->forget('lastSessionCardId');
//            return response()->json([
//                'end' => true,
//                'url' => route('dashboard'),
//            ]);
//        }
//
//        $card = $session_card->card;
//
//        session()->put('lastSessionCardId', $session_card->id);

//        return response()->json([
//            'session_card_id' => $session_card->id,
//            'front' => $card->front,
//            'back' => $card->back,
//            'intervals' => $this->calculateNextIntervals($card->interval),
//            'end' => false,
//        ], 200);
//    }
//
//    public function answer(Request $request)
//    {
//        return response()->json([
//            'success' => true,
//        ]);
//        $request->validate([
//            'session_card_id' => 'required|integer|exists:session_cards,id',
//            'rating' => 'required|in:again,hard,good,easy',
//        ]);
//
//        $session_card = SessionCard::findOrFail($request->session_card_id);
//        $card = $session_card->card;
//        $rating = $request->rating;
//
//        $nextInterval = $this->calculateNextIntervals($card->interval)[$rating];
//        $newReviewDate = Carbon::now()->addDays($nextInterval)->toDateString();
//        $type = $nextInterval >= 3 ? 'review' : 'learning';
//
//        $card->update([
//            'interval' => $nextInterval,
//            'next_review_date' => $newReviewDate,
//            'type' => $type,
//        ]);
//
//        if ($nextInterval >= 1) {
//            $session_card->update([
//                'retry_later' => 0,
//            ]);
////        }
//    }
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

    public function calculateNextIntervals($current_interval)
    {
        $coefficients = [
            'again' => 0.0,
            'hard' => 2.0,
            'good' => 3.0,
            'easy' => 5.0,
        ];

        return [
            'again' => max($current_interval * $coefficients['again'], 0.1),
            'hard' => $current_interval * $coefficients['hard'],
            'good' => $current_interval * $coefficients['good'],
            'easy' => max($current_interval * $coefficients['easy'], 5),
        ];
    }
}
