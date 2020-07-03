<?php


namespace App\Repositories\FileTokens\Queries;


use App\Models\FileLinkToken;
use Illuminate\Database\Eloquent\Builder;

final class FileLinkTokenQueries
{
    /**
     * @param Builder|FileLinkToken $query
     * @return FileLinkToken|Builder
     */
    public function withVisitsCount($query)
    {
        $query->withCount('visits');

        return $query;
    }

    /**
     * @param Builder|FileLinkToken $query
     * @param string                $type
     * @return FileLinkToken|Builder
     */
    public function whereType($query, string $type)
    {
        $query->whereType($type);

        return $query;
    }
}
