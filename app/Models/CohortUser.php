<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CohortUser extends Model
{
    protected $table = 'cohort_user';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}

