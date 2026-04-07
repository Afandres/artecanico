<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentTreatment extends Model
{
    protected $fillable = [
        'appointment_id',
        'treatment_id',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}
