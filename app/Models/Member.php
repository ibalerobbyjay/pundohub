<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

   protected $fillable = [
    'name',
    'email',
    'password',
    'household',
    'contact',
    'role',
];


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
