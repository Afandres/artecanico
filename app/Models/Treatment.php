<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function getDescriptionNullableAttribute(){
        return $this->description ?? 'Sin descripción';
    }
}
