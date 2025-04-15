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

    /**
     * Get the user who created the assessment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    /**
     * Get the cohort associated with the assessment.
     */
    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
