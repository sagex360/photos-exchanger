<?php


namespace App\Repositories\FileTokens;


use App\Models\FileLinkToken;
use Illuminate\Database\Eloquent\Collection;

interface FileTokensRepository
{
    /**
     * @param  string  $token
     * @return FileLinkToken
     */
    public function findByToken(string $token): FileLinkToken;

    /**
     * @param  int  $id
     * @return FileLinkToken
     */
    public function findWithTrashedById(int $id): FileLinkToken;

    /**
     * @param  int  $fileId
     * @return Collection|FileLinkToken[]
     */
    public function findByFileId(int $fileId): Collection;

    /**
     * @return Collection|FileLinkToken[]
     */
    public function all(): Collection;

    /**
     * @param  int  $id
     * @return FileLinkToken
     */
    public function findById(int $id): FileLinkToken;
}
