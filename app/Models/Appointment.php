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
        'payment_method',
        'photo',
        'checkin_time',
        'checkin_photo',
        'checkin_observations',
        'process_photo',
        'process_observations',
        'checkout_time',
        'checkout_photo',
        'checkout_observations',
        'pet_name_temp',
        'owner_name_temp',
        'gender_temp',
        'phone_temp',
    ];

    protected $appends = ['payment_method_label'];
    
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

    public function getPaymentMethodLabelAttribute()
    {
        return [
            'Llave_nequi' => 'Llave Nequi',
            'Llave_daviplata' => 'Llave Daviplata',
        ][$this->payment_method] ?? $this->payment_method;
    }
}