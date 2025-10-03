<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ correct import
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'household',
        'contact',
        'is_verified',
    ];

    // A Member may belong to a User account
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A Member can have many donations
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    // A Member can be part of bereavement cases (as deceased)
    public function bereavementCases()
    {
        return $this->hasMany(BereavementCase::class);
    }
}
