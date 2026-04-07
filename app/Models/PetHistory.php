<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetHistory extends Model
{
    protected $fillable = [
        'appointment_id',
        'description',
        'photo'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
