<?php


namespace App\DTO\FileLinks;


use App\Models\File;
use App\ValueObjects\LinkToken\LinkToken;

final class CreateFileLinkDto
{
    protected File $file;
    protected LinkToken $token;

    /**
     * CreateFileLinkTokenDto constructor.
     * @param  File  $file
     * @param  LinkToken  $token
     */
    public function __construct(File $file, LinkToken $token)
    {
        $this->file = $file;
        $this->token = $token;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @return LinkToken
     */
    public function getToken(): LinkToken
    {
        return $this->token;
    }
}
