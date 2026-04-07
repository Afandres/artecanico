<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'client_id',
        'breed_id',
        'name',
        'observations',
        'profile_photo'
    ];

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
