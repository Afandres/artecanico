<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'emergency_phone',
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}
