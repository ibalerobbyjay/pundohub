<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeathReport extends Model
{
    protected $fillable = [
        'user_id',
        'name_of_deceased',
        'date_of_death',
        'cause_of_death',
        'other_cause',
        'location_of_death',
        'notes',
        'death_certificate',
        'is_verified'
    ];

    // Cast date_of_death to a Carbon instance
    protected $casts = [
        'date_of_death' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with user who submitted the report
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}