<?php

namespace App\Policies;

use App\User;
use App\Song;
use Illuminate\Auth\Access\HandlesAuthorization;

class SongPolicy
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
     * Determine whether the user can view songs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasAccess(['list-songs']);
    }

    /**
     * Determine whether the user can create songs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess(['create-song']);
    }

    /**
     * Determine whether the user can update the song.
     *
     * @param  \App\User  $user
     * @param  \App\Song  $song
     * @return mixed
     */
    public function update(User $user, Song $song)
    {
        return $user->hasAccess(['update-song']) || $user->id === $song->author_id;        
    }

    /**
     * Determine whether the user can delete the song.
     *
     * @param  \App\User  $user
     * @param  \App\Song  $song
     * @return mixed
     */
    public function delete(User $user, Song $song)
    {
        return $user->hasAccess(['delete-song']) || $user->id === $song->author_id;        
    }

    /**
     * Determine whether the user can restore the song.
     *
     * @param  \App\User  $user
     * @param  \App\Song  $song
     * @return mixed
     */
    public function restore(User $user, Song $song)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the song.
     *
     * @param  \App\User  $user
     * @param  \App\Song  $song
     * @return mixed
     */
    public function forceDelete(User $user, Song $song)
    {
        //
    }
}
