<?php

namespace App\Policies;

use App\User;
use App\Note;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the note.
     *
     * @param  \App\User  $user
     * @param  \App\Note  $note
     * @return mixed
     */
    public function view(User $user, Note $note)
    {
        return (int)$note->user_id === $user->id;
    }

    /**
     * Determine whether the user can create notes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the note.
     *
     * @param  \App\User  $user
     * @param  \App\Note  $note
     * @return mixed
     */
    public function update(User $user, Note $note)
    {
        return (int)$note->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the note.
     *
     * @param  \App\User  $user
     * @param  \App\Note  $note
     * @return mixed
     */
    public function delete(User $user, Note $note)
    {
        return (int)$note->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the note.
     *
     * @param  \App\User  $user
     * @param  \App\Note  $note
     * @return mixed
     */
    public function restore(User $user, Note $note)
    {
        return (int)$note->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the note.
     *
     * @param  \App\User  $user
     * @param  \App\Note  $note
     * @return mixed
     */
    public function forceDelete(User $user, Note $note)
    {
        return (int)$note->user_id === $user->id;
    }
}
