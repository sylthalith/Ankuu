<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'study_session_id',
        'card_id',
        'retry_later',
    ];

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function session()
    {
        return $this->belongsTo(StudySession::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
