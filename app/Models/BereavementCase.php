<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BereavementCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'title',
        'date_of_death',
        'description', // updated to match your form
    ];

    // Cast date_of_death to a Carbon instance
    protected $casts = [
        'date_of_death' => 'date',
    ];

    // Relationship to Member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
