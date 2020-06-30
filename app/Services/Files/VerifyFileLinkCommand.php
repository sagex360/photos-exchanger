<?php


namespace App\Services\Files;


use App\Exceptions\FileTokenExpiredException;
use App\Models\FileLinkToken;

final class VerifyFileLinkCommand
{
    /**
     * @param FileLinkToken $fileLinkToken
     * @throws FileTokenExpiredException
     */
    public function execute(FileLinkToken $fileLinkToken)
    {
        if ($fileLinkToken->expired()) {
            throw new FileTokenExpiredException('Token expired');
        }
    }
}
