<?php


namespace App\DTO\Files;


use App\Models\File;
use App\ValueObjects\DeletionDate\DeletionDate;
use App\ValueObjects\FileDescription;

final class UpdateFileDto
{
    private File $file;
    private FileDescription $description;
    private DeletionDate $dateToDelete;

    /**
     * UpdateFileDto constructor.
     * @param  File  $file
     * @param  FileDescription  $description
     * @param  DeletionDate  $dateToDelete
     */
    public function __construct(File $file, FileDescription $description, DeletionDate $dateToDelete)
    {
        $this->file = $file;
        $this->description = $description;
        $this->dateToDelete = $dateToDelete;
    }

    /**
     * @return DeletionDate
     */
    public function getDateToDelete(): DeletionDate
    {
        return $this->dateToDelete;
    }

    /**
     * @return FileDescription
     */
    public function getDescription(): FileDescription
    {
        return $this->description;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }
}
