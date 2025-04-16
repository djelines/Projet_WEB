<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->school()->pivot->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->school()->pivot->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->school()->pivot->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine if the user has the required role to manage the model.
     *
     * @param User $user
     * @return bool
     */
    public function manage(User $user)
    {
        return $user->school()->pivot->role === 'admin';
    }

    /**
     * Determine if the user is allowed to point tasks.
     *
     * @param User $user
     * @return bool
     */
    public function point(User $user)
    {
        return $user->school()->pivot->role === 'student';
    }

    /**
     * Determine if the user is authorized to view historical task data.
     *
     * @param User $user
     * @param Task|null $task
     * @return bool
     */
    public function viewHistory(User $user, Task $task = null)
    {
        return $user->school()->pivot->role === 'student';
    }

    /**
     * Determine if the user is authorized to view tasks completed by students.
     *
     * @param User $user
     * @return bool
     */
    public function viewCompletedByStudents(User $user)
    {
        return $user->school()->pivot->role === 'admin';
    }




}
