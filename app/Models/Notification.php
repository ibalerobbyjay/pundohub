<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Notification extends Model
{
    protected $fillable = ['title', 'message', 'user_id', 'read_at'];

    // Optional: mark notification as read
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }
}

