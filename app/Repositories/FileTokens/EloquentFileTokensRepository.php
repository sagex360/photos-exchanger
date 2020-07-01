<?php


namespace App\Repositories\FileTokens;


use App\Models\FileLinkToken;
use App\Repositories\FileTokens\Queries\FileLinkTokenQueries;
use Illuminate\Database\Eloquent\Collection;

final class EloquentFileTokensRepository extends FileTokensRepository
{
    protected FileLinkTokenQueries $fileLinkTokenQueries;

    public function __construct(FileLinkTokenQueries $fileLinkTokenQueries)
    {
        $this->fileLinkTokenQueries = $fileLinkTokenQueries;
    }

    public function findByToken(string $token): FileLinkToken
    {
        $builder = FileLinkToken::whereToken($token);
        $this->fileLinkTokenQueries->withVisitsCount($builder);

        return $builder->firstOrFail();
    }

    public function findWithTrashedById(int $id): FileLinkToken
    {
        return FileLinkToken::withTrashed()->findOrFail($id);
    }

    public function findByFileId(int $fileId): Collection
    {
        return FileLinkToken::whereFileId($fileId)->get();
    }

    public function all(): Collection
    {
        return FileLinkToken::all();
    }

    public function findById(int $id): FileLinkToken
    {
        return FileLinkToken::findOrFail($id);
    }
}
