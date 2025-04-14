<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    protected $table        = 'cohorts';
    protected $fillable     = ['school_id', 'name', 'description', 'start_date', 'end_date'];

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'cohort_user');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'cohort_task')->withTimestamps();
    }


}
