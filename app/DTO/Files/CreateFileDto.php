<?php


namespace App\DTO\Files;


use App\ValueObjects\DeletionDate\DeletionDate;
use App\ValueObjects\FileDescription;
use Illuminate\Http\UploadedFile;

final class CreateFileDto
{
    protected int $userId;
    protected UploadedFile $image;
    protected DeletionDate $dateToDelete;
    protected FileDescription $description;

    /**
     * CreateFileDto constructor.
     * @param  int  $userId
     * @param  UploadedFile  $image
     * @param  FileDescription  $description
     * @param  DeletionDate  $dateToDelete
     */
    public function __construct(
        int $userId,
        UploadedFile $image,
        FileDescription $description,
        DeletionDate $dateToDelete
    ) {
        $this->userId = $userId;
        $this->image = $image;
        $this->description = $description;
        $this->dateToDelete = $dateToDelete;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getImage(): UploadedFile
    {
        return $this->image;
    }

    public function getDescription(): FileDescription
    {
        return $this->description;
    }

    public function getDateToDelete(): DeletionDate
    {
        return $this->dateToDelete;
    }
}
