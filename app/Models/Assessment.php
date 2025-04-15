<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        "questions",
        "languages",
        "difficulty",
        "num_questions",
        "user_id",
        "cohort_id",
    ];

    protected $casts = [
        "questions" => "array",
        "languages" => "array",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
