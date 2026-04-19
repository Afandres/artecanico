<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'client_id',
        'breed_id',
        'name',
        'sobriquet',
        'age',
        'gender',
        'medical_condition',
        'observations',
        'profile_photo'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
    }

    public function setSobriquetAttribute($value)
    {
        $this->attributes['sobriquet'] = mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }

    public function getAgeNullableAttribute(){
        return $this->age ?? 'No registra';
    }

    public function getMedicalConditionNullableAttribute(){
        return $this->medical_condition ?? 'No registra';
    }

    public function getObservationsNullableAttribute(){
        return $this->observations ?? 'No registra';
    }
        
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
