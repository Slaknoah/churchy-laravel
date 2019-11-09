<?php

namespace App\Policies;

use App\User;
use App\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
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
     * Determine whether the user can create messages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess(['create-message']);
    }

    /**
     * Determine whether the user can update the message.
     *
     * @param  \App\User  $user
     * @param  \App\message  $message
     * @return mixed
     */
    public function update(User $user, Message $message)
    {
        return $user->hasAccess(['update-message']) || $user->id === $message->author_id;
    }

    /**
     * Determine whether the user can delete the message.
     *
     * @param  \App\User  $user
     * @param  \App\message  $message
     * @return mixed
     */
    public function delete(User $user, Message $message)
    {
        return $user->hasAccess(['delete-message']) || $user->id === $message->author_id;
    }

    /**
     * Determine whether the user can restore the message.
     *
     * @param  \App\User  $user
     * @param  \App\message  $message
     * @return mixed
     */
    public function restore(User $user, Message $message)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the message.
     *
     * @param  \App\User  $user
     * @param  \App\message  $message
     * @return mixed
     */
    public function forceDelete(User $user, Message $message)
    {
        //
    }
}
