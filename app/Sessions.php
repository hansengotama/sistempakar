<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    protected $fillable = [
        'user_id', 'disease_id'
    ];

    public function disease()
    {
        return $this->belongsTo(Diseases::class);
    }

    public function answers()
    {
        return $this->hasMany(SessionAnswers::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
