<?php


namespace App\Repositories\FileTokens;


use App\Models\FileLinkToken;

abstract class FileTokensRepository
{
    /**
     * @param string $token
     * @return FileLinkToken
     */
    public abstract function findByToken(string $token): FileLinkToken;

    /**
     * @param int $id
     * @return FileLinkToken
     */
    public abstract function findWithTrashedById(int $id): FileLinkToken;
}
