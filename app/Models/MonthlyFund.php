<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyFund extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'amount',
    'month_year',
    'proof_of_payment',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
