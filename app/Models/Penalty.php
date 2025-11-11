<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'reason',
        'applied_at',
        'due_date',
        'paid',
        'paid_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'paid' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Add this accessor to check if penalty is overdue
    public function getIsOverdueAttribute()
    {
        if (!$this->due_date || $this->paid) {
            return false;
        }
        
        return now()->greaterThan($this->due_date);
    }
}