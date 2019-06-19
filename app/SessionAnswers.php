<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionAnswers extends Model
{
    protected $fillable = [
        "sessions_id", "question_id", "answer"
    ];

    public function question()
    {
        return $this->belongsTo(Questions::class);
    }
}
