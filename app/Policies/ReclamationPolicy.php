<?php

namespace App\Policies;

use App\Models\Reclamation;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReclamationPolicy
{
    use HandlesAuthorization;


    public function before(User $user)
    {

        if ($user->role == "accountant" || $user->role == "admin") {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reclamation  $reclamation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Reclamation $reclamation)
    {
        //обновление полей по ролям смотри в контроллере
        return Recruiter::recruitersAcces($user)->where('id', $reclamation->recruiter_id)->get('id')->isNotEmpty();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reclamation  $reclamation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Reclamation $reclamation)
    {
        return $user->id === $reclamation->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reclamation  $reclamation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Reclamation $reclamation)
    {
        return $user->id === $reclamation->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reclamation  $reclamation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Reclamation $reclamation)
    {
        return false;
    }
}
