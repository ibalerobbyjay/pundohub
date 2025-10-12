<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BereavementCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'date_of_death',
        'description',
        'remarks',
    ];

    protected $casts = [
        'date_of_death' => 'date',
    ];

    // Relationship to User (Member)
   public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
