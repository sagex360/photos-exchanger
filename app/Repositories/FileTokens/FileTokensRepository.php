<?php


namespace App\Repositories\FileTokens;


use App\Models\FileLinkToken;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * @param int $fileId
     * @return Collection|FileLinkToken[]
     */
    public abstract function findByFileId(int $fileId): Collection;

    /**
     * @return Collection|FileLinkToken[]
     */
    public abstract function all(): Collection;

    /**
     * @param int $id
     * @return FileLinkToken
     */
    public abstract function findById(int $id): FileLinkToken;
}
