<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name_of_deceased',
        'date_of_death',
        'cause_of_death',
        'location_of_death',
        'notes',
        'death_certificate',
        'is_verified',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'date_of_death' => 'date',
        'verified_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Scope for verified reports
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Scope for pending reports
    public function scopePending($query)
    {
        return $query->where('is_verified', false);
    }

    // Check if report is duplicate
    public function isDuplicate()
    {
        return self::where('name_of_deceased', $this->name_of_deceased)
            ->where('id', '!=', $this->id)
            ->exists();
    }
}