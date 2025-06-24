<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'total_cards'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function session()
    {
        return $this->hasOne(StudySession::class);
    }

    public function sessionCards()
    {
        return $this->hasMany(SessionCard::class);
    }
}
