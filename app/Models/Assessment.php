<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'questions', 'languages', 'difficulty', 'num_questions', 'brouillon',
    ];

    protected $casts = [
        'questions' => 'array',
        'languages' => 'array',
        'brouillon' => 'boolean', // Cast de 'brouillon' en booléen
    ];
}
