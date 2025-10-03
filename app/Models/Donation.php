<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'bereavement_case_id',
        'amount',
        'type',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function bereavementCase()
    {
        return $this->belongsTo(BereavementCase::class);
    }
}
