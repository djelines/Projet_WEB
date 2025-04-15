<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    protected $table        = 'cohorts';
    protected $fillable     = ['school_id', 'name', 'description', 'start_date', 'end_date'];

    /**
      * Get all assessments associated with this cohort.
      */
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    /**
      * Get all users (students, etc.) belonging to this cohort.
      */
    public function users()
    {
        return $this->belongsToMany(User::class, 'cohort_user');
    }

    /**
      * Get all tasks linked to this cohort.
      */
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'cohort_task')->withTimestamps();
    }


}
