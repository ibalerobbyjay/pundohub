<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'household',
        'contact',
        'job_type',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // A User may also be a Member
    public function member()
    {
        return $this->hasOne(Member::class);
    }

   public function penalties()
{
    return $this->hasMany(Penalty::class);
}

    public function monthlyFunds()
    {
        return $this->hasMany(MonthlyFund::class);
    }
    
    
}