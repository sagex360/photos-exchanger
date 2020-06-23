<?php


namespace App\Events\Files;


final class FileCreated
{
    protected int $fileId;

    public function __construct(int $fileId)
    {
        $this->fileId = $fileId;
    }
}
