<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'month_price', 'year_price', 'trail_days', 'currency'])]
class Plan extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
