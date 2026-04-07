<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    protected $fillable = [
        'name',
        'description',
        'size'
    ];

    public function getDescriptionNullableAttribute(){
        return $this->description ?? 'Sin descripción';
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}
