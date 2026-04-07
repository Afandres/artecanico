<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    protected $fillable = [
        'name',
        'description',
        'size',
        'average_grooming_time',
    ];

    public function getDescriptionNullableAttribute(){
        return $this->description ?? 'Sin descripción';
    }

    public function getFormattedGroomingTimeAttribute(){
        $minutes = $this->average_grooming_time;

        if ($minutes < 60) {
            return $minutes . ' minutos';
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        $hourText = $hours == 1 ? 'hora' : 'horas';

        if ($remainingMinutes == 0) {
            return $hours . ' ' . $hourText;
        }

        return $hours . ' ' . $hourText . ' ' . $remainingMinutes . ' min';
    }
}
