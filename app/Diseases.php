<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diseases extends Model
{
    protected $fillable = [
        'name'
    ];

    public function diseasesSolution()
    {
        return $this->hasMany(DiseaseSolutions::class);
    }
}
