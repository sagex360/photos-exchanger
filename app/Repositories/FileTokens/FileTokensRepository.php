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
    abstract public function findByToken(string $token): FileLinkToken;

    /**
     * @param int $id
     * @return FileLinkToken
     */
    abstract public function findWithTrashedById(int $id): FileLinkToken;

    /**
     * @param int $fileId
     * @return Collection|FileLinkToken[]
     */
    abstract public function findByFileId(int $fileId): Collection;

    /**
     * @return Collection|FileLinkToken[]
     */
    abstract public function all(): Collection;

    /**
     * @param int $id
     * @return FileLinkToken
     */
    abstract public function findById(int $id): FileLinkToken;
}
