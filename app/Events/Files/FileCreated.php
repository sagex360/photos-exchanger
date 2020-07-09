<?php


namespace App\Events\Files;


final class FileCreated
{
    private int $fileId;

    public function __construct(int $fileId)
    {
        $this->fileId = $fileId;
    }

    /**
     * @return int
     */
    public function getFileId(): int
    {
        return $this->fileId;
    }
}
