<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solutions extends Model
{
    protected $fillable = [
        'context'
    ];

    public function solution()
    {
        return $this->hasMany(Solutions::class);
    }
}
