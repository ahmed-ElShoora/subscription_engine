<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// #[Fillable(['user_id', 'amount', 'currency', 'status', 'card_last_four'])]

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'status',
        'card_last_four'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
