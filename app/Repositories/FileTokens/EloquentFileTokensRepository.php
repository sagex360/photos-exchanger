<?php


namespace App\Repositories\FileTokens;


use App\Models\FileLinkToken;
use App\Repositories\FileTokens\Queries\FileLinkTokenQueries;

final class EloquentFileTokensRepository extends FileTokensRepository
{
    protected FileLinkTokenQueries $fileLinkTokenQueries;

    public function __construct(FileLinkTokenQueries $fileLinkTokenQueries)
    {
        $this->fileLinkTokenQueries = $fileLinkTokenQueries;
    }

    public function find(string $token): FileLinkToken
    {
        $builder = FileLinkToken::whereToken($token);
        $this->fileLinkTokenQueries->withVisitsCount($builder);

        return $builder->firstOrFail();
    }
}
