<?php


namespace App\Services\Files;


use App\Models\FileLinkToken;
use App\Models\LinkVisit;

final class RecordLinkVisitCommand
{
    /**
     * @param FileLinkToken $linkToken
     */
    public function execute(FileLinkToken $linkToken): void
    {
        $newVisit = new LinkVisit();
        $newVisit->link_token_id = $linkToken->id;
        $newVisit->save();
    }
}
