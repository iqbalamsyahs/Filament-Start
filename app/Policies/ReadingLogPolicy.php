<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReadingLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReadingLogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_reading::log');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ReadingLog $readingLog): bool
    {
        return $user->can('view_reading::log');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_reading::log');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ReadingLog $readingLog): bool
    {
        return $user->can('update_reading::log');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ReadingLog $readingLog): bool
    {
        return $user->can('delete_reading::log');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_reading::log');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, ReadingLog $readingLog): bool
    {
        return $user->can('force_delete_reading::log');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_reading::log');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, ReadingLog $readingLog): bool
    {
        return $user->can('restore_reading::log');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_reading::log');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, ReadingLog $readingLog): bool
    {
        return $user->can('replicate_reading::log');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_reading::log');
    }
}
