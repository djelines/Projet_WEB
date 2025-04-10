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

    /**
     * Define the Many-to-Many relationship between tasks and users.
     *
     * This method establishes a relationship between a task and the users who are associated with it.
     * It includes the `completed` and `comment` fields from the pivot table, and timestamps for the association.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany The relationship instance.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user')
                    ->withPivot('completed', 'comment')
                    ->withTimestamps();
    }

    /**
     * Define the Many-to-Many relationship for completed tasks by students.
     *
     * This method filters the relationship to only include users who have marked the task as completed.
     * It returns users who are associated with the task and have `completed` set to `true` in the pivot table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany The relationship instance for users who completed the task.
     */
    public function completedStudents()
    {
        return $this->belongsToMany(User::class, 'task_user')
                    ->withPivot('completed', 'comment')
                    ->wherePivot('completed', true);
    }

}
