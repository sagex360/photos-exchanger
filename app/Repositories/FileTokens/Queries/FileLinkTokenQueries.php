<?php


namespace App\Repositories\FileTokens\Queries;


use App\Models\FileLinkToken;
use Illuminate\Database\Eloquent\Builder;

final class FileLinkTokenQueries
{
    /**
     * @var Builder|FileLinkToken $query
     */
    public function withVisitsCount($query)
    {
        $query->withCount('visits');
    }
}
