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
        'notes',
        'death_certificate',
        'is_verified',
        'verified_at',
    ];
     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
