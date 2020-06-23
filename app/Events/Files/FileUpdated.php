<?php


namespace App\Events\Files;


final class FileUpdated
{
    protected int $fileId;

    /**
     * FileUpdated constructor.
     * @param int $fileId
     */
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
