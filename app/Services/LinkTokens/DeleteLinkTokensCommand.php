<?php


namespace App\Services\LinkTokens;


use App\Models\FileLinkToken;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

final class DeleteLinkTokensCommand
{
    /**
     * @param FileLinkToken[]|Collection $linkTokens
     * @throws Exception
     */
    public function execute(Collection $linkTokens)
    {
        /**
         * @var Builder|FileLinkToken $query
         */
        $query = FileLinkToken::whereIn('id', $linkTokens->pluck('id'));
        $query->delete();
    }
}
