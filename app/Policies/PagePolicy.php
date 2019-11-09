<?php

namespace App\Policies;

use App\User;
use App\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
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
     * Determine whether the user can view the page.
     *
     * @param  \App\User  $user
     * @param  \App\Page  $page
     * @return mixed
     */
    public function view(User $user, Page $page)
    {
        //
    }

    /**
     * Determine whether the user can create pages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess(['create-page']);        
    }

    /**
     * Determine whether the user can update the page.
     *
     * @param  \App\User  $user
     * @param  \App\Page  $page
     * @return mixed
     */
    public function update(User $user, Page $page)
    {
        return $user->hasAccess(['update-article']) || $user->id === $page->author_id;        
    }

    /**
     * Determine whether the user can delete the page.
     *
     * @param  \App\User  $user
     * @param  \App\Page  $page
     * @return mixed
     */
    public function delete(User $user, Page $page)
    {
        return $user->hasAccess(['delete-page']) || $user->id === $page->author_id;        
    }

    /**
     * Determine whether the user can restore the page.
     *
     * @param  \App\User  $user
     * @param  \App\Page  $page
     * @return mixed
     */
    public function restore(User $user, Page $page)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the page.
     *
     * @param  \App\User  $user
     * @param  \App\Page  $page
     * @return mixed
     */
    public function forceDelete(User $user, Page $page)
    {
        //
    }
}
