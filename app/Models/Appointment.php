<?php
// app/Models/Appointment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'pet_id',
        'appointment_date',
        'status',
        'observations',
        'price',
        'photo',
        'checkin_time',
        'checkin_photo',
        'checkin_observations',
        'checkout_time',
        'checkout_observations',
        'final_price'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function treatments(): BelongsToMany
    {
        return $this->belongsToMany(Treatment::class, 'appointments_treatments');
    }
    
    // Scope para citas del día
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }
    
    // Scope para citas pendientes de checkin
    public function scopePendingCheckin($query)
    {
        return $query->whereNull('checkin_time')
                     ->where('status', '!=', 'Cancelada');
    }
    
    // Scope para citas en proceso (con checkin pero sin checkout)
    public function scopeInProgress($query)
    {
        return $query->whereNotNull('checkin_time')
                     ->whereNull('checkout_time')
                     ->where('status', '!=', 'Cancelada');
    }
}