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
        return $assessment->cohort->users->contains($user) ;
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->school()->pivot->role === 'admin' or $user->school()->pivot->role === 'teacher';
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

    /**
     * Determine if the user can view the history of assessment results.
     * Only admins and teachers are allowed.
     */
    public function viewHistory(User $user, Assessment $assessment)
    {
        return $user->school()->pivot->role === 'admin' || $user->school()->pivot->role === 'teacher';
    }

    /**
     * Determine if the user can submit this assessment.
     * Only allowed if the user belongs to the assessment's cohort.
     */
    public function submit(User $user, Assessment $assessment)
    {
        return $assessment->cohort->users->contains($user);
    }

    /**
     * Determine if the user can view the result of the assessment.
     * Only admins and teachers are allowed.
     */
    public function result(User $user, Assessment $assessment)
    {
        return $user->school()->pivot->role === 'admin' || $user->school()->pivot->role === 'teacher';
    }

    /**
     * Determine if the user can view the QCM content of the assessment.
     * Only admins and teachers are allowed.
     */
    public function viewQcm(User $user, Assessment $assessment)
    {
        return $user->school()->pivot->role === 'admin' || $user->school()->pivot->role === 'teacher';
    }

    /**
     * Determine if the user is allowed to answer the QCM.
     * Only students are allowed.
     */
    public function answerQcm(User $user, Assessment $assessment)
    {
        return $user->school()->pivot->role === 'student';
    }


}
