<?php

namespace App\Policies;

use App\Exceptions\IncompatibleParentAndChildModelsException;
use App\Models\Client;
use App\Models\File;
use App\Models\FileLinkToken;
use Illuminate\Auth\Access\HandlesAuthorization;

class FileLinksPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the file link token.
     *
     * @param  Client  $user
     * @param  File  $parentFile
     * @return bool
     */
    public function viewAnyOf(Client $user, File $parentFile): bool
    {
        return $user->can('view', $parentFile);
    }

    /**
     * @param  Client  $user
     * @param  FileLinkToken  $linkToken
     * @return bool
     */
    public function view(Client $user, FileLinkToken $linkToken)
    {
        return $user->can('viewAnyOf', [FileLinkToken::class, $linkToken->file]);
    }

    /**
     * Determine whether the user can create file link tokens.
     *
     * @param  Client  $user
     * @param  File  $parentFile
     * @return bool
     */
    public function createOf(Client $user, File $parentFile): bool
    {
        return $user->can('view', $parentFile);
    }

    /**
     * Determine whether the user can delete the file link token.
     *
     * @param  Client  $user
     * @param  FileLinkToken  $fileLinkToken
     * @param  File  $tokenParent
     * @return bool
     */
    public function deleteOf(Client $user, FileLinkToken $fileLinkToken, File $tokenParent): bool
    {
        $this->verifyTokenParent($fileLinkToken, $tokenParent);

        return $user->can('view', $tokenParent);
    }

    protected function verifyTokenParent(FileLinkToken $fileLinkToken, File $tokenParent): void
    {
        if ($fileLinkToken->file_id !== $tokenParent->id) {
            throw new IncompatibleParentAndChildModelsException(
                "Token {$fileLinkToken->id} does not correspond to its parent {$tokenParent->id}"
            );
        }
    }
}
