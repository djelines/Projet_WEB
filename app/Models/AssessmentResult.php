<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    protected $fillable = ['assessment_id', 'user_id', 'answers', 'score'];

    protected $casts = [
        'answers' => 'array',
    ];

    /**
     * Get the assessment associated with this result.
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Get the user who submitted this result.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
