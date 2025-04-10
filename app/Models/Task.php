<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // protect the database and attributes
    protected $table        = 'tasks';
    protected $fillable     = ['title', 'description', 'category', 'user_id'];


    /**
     * The user can add numerous tasks 
     */
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation Many-to-Many with students
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user')
                    ->withPivot('completed', 'comment')
                    ->withTimestamps();
    }

    public function completedStudents()
    {
        return $this->belongsToMany(User::class, 'task_user')
                    ->withPivot('completed', 'comment')
                    ->wherePivot('completed', true);
    }
}
