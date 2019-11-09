<?php

namespace App\Policies;

use App\User;
use App\Serie;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeriesPolicy
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
     * Determine whether the user can view the serie.
     *
     * @param  \App\User  $user
     * @param  \App\Serie  $serie
     * @return mixed
     */
    public function view(User $user, Serie $serie)
    {
        //
    }

    /**
     * Determine whether the user can create series.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the serie.
     *
     * @param  \App\User  $user
     * @param  \App\Serie  $serie
     * @return mixed
     */
    public function update(User $user, Serie $serie)
    {
        //
    }

    /**
     * Determine whether the user can delete the serie.
     *
     * @param  \App\User  $user
     * @param  \App\Serie  $serie
     * @return mixed
     */
    public function delete(User $user, Serie $serie)
    {
        //
    }

    /**
     * Determine whether the user can restore the serie.
     *
     * @param  \App\User  $user
     * @param  \App\Serie  $serie
     * @return mixed
     */
    public function restore(User $user, Serie $serie)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the serie.
     *
     * @param  \App\User  $user
     * @param  \App\Serie  $serie
     * @return mixed
     */
    public function forceDelete(User $user, Serie $serie)
    {
        //
    }
}
