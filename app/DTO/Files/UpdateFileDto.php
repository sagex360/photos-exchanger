<?php


namespace App\DTO\Files;


use App\ValueObjects\DeletionDate\DeletionDate;
use App\ValueObjects\FileDescription;

final class UpdateFileDto
{
    protected int $id;

    protected FileDescription $description;

    protected DeletionDate $dateToDelete;

    /**
     * UpdateFileDto constructor.
     * @param int             $id
     * @param FileDescription $description
     * @param DeletionDate    $dateToDelete
     */
    public function __construct(int $id, FileDescription $description, DeletionDate $dateToDelete)
    {
        $this->id = $id;
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
