<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'emergency_phone',
        'preference',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
