<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable = [
        'deck_id',
        'front',
        'back',
        'interval',
        'type',
        'next_review_date',
    ];

    protected $casts = [
        'next_review_date' => 'date',
        'easiness_factor' => 'float',
    ];

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }
}
