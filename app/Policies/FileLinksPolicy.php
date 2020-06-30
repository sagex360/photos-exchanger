<?php

namespace App\Policies;

use App\Exceptions\IncompatibleParentAndChildModelsException;
use App\Models\File;
use App\Models\FileLinkToken;
use App\Models\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class FileLinksPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the file link token.
     *
     * @param Client $user
     * @param File   $parentFile
     * @return bool
     */
    public function viewAnyOf(Client $user, File $parentFile)
    {
        return $user->can('view', $parentFile);
    }

    /**
     * Determine whether the user can create file link tokens.
     *
     * @param Client $user
     * @param File   $parentFile
     * @return bool
     */
    public function createOf(Client $user, File $parentFile)
    {
        return $user->can('view', $parentFile);
    }

    /**
     * Determine whether the user can delete the file link token.
     *
     * @param Client        $user
     * @param FileLinkToken $fileLinkToken
     * @param File          $tokenParent
     * @return bool
     */
    public function deleteOf(Client $user, FileLinkToken $fileLinkToken, File $tokenParent)
    {
        $this->verifyTokenParent($fileLinkToken, $tokenParent);

        return $user->can('view', $tokenParent);
    }

    protected function verifyTokenParent(FileLinkToken $fileLinkToken, File $tokenParent)
    {
        if ($fileLinkToken->file_id !== $tokenParent->id) {
            throw new IncompatibleParentAndChildModelsException(
                "Token {$fileLinkToken->id} does not correspond to its parent {$tokenParent->id}"
            );
        }
    }
}
