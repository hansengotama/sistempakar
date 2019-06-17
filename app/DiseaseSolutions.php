<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiseaseSolutions extends Model
{
    protected $fillable = [
        'solution_id', 'disease_id'
    ];

    public function solution()
    {
        return $this->belongsTo(Solutions::class);
    }

    public function disease()
    {
        return $this->belongsTo(Diseases::class);
    }
}
