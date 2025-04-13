<?php

namespace App\Policies;

use App\Models\Assessment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AssessmentPolicy
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
    public function view(User $user, Assessment $assessment)
    {
        // Vérifie si l'utilisateur fait partie de la cohorte associée au bilan
        return $assessment->cohort->users->contains($user);
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->school()->pivot->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assessment $assessment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assessment $assessment)
    {
        return $user->school()->pivot->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Assessment $assessment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Assessment $assessment): bool
    {
        return false;
    }

    public function viewHistory(User $user, Assessment $assessment)
    {
        return $user->school()->pivot->role === 'admin';
    }

    public function submit(User $user, Assessment $assessment)
    {
        return $assessment->cohort->users->contains($user);
    }

    public function result(User $user, Assessment $assessment)
    {
        return $assessment->cohort->users->contains($user);
    }
}
