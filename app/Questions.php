<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $fillable = [
        'disease_id', 'parent_id', 'question'
    ];
}
