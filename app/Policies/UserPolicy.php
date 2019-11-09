<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{

    use HandlesAuthorization;

    /**
     * Authorize all action for admin
     */
    public function before($user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether current user can list users 
     */
    public function list(User $user) {
        return false;
    }
    

    /**
     * Determine whether the user can view the  user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $User
     * @return mixed
     */
    public function view(User $authUser, User $reqUser)
    {
        return $authUser->id === $reqUser->id;
    }

    /**
     * Determine whether the user can create  users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the  user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $User
     * @return mixed
     */
    public function update(User $authUser, User $reqUser)
    {
        return $authUser->id === $reqUser->id;
    }

    /**
     * Determine whether the user can delete the  user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $User
     * @return mixed
     */
    public function delete(User $authUser, User $reqUser)
    {
        return $authUser->id === $reqUser->id;
    }

    /**
     * Determine whether the user can restore the  user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $User
     * @return mixed
     */
    public function restore(User $user, User $User)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the  user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $User
     * @return mixed
     */
    public function forceDelete(User $user, User $User)
    {
        //
    }

    /**
     * Update userRole
     */
    public function updateUserRole(User $user) {
        return false;
    }
    
    /**
     * Update password
     */
    public function changePassword(User $authUser, User $reqUser) {
        return $authUser->id == $reqUser->id;
    }
}
