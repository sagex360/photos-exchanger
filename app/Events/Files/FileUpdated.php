<?php


namespace App\Events\Files;


final class FileUpdated
{
    private int $fileId;

    /**
     * FileUpdated constructor.
     * @param  int  $fileId
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
