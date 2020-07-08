<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\File;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the file.
     *
     * @param  Client  $user
     * @param  File  $file
     * @return bool
     */
    public function view(Client $user, File $file): bool
    {
        return $file->isOwnedBy($user);
    }

    /**
     * Determine whether the user can create files.
     *
     * @param  Client  $user
     * @return bool
     */
    public function create(Client $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the file.
     *
     * @param  Client  $user
     * @param  File  $file
     * @return bool
     */
    public function update(Client $user, File $file): bool
    {
        return $file->isOwnedBy($user);
    }

    /**
     * Determine whether the user can delete the file.
     *
     * @param  Client  $user
     * @param  File  $file
     * @return bool
     */
    public function delete(Client $user, File $file): bool
    {
        return $file->isOwnedBy($user);
    }
}
