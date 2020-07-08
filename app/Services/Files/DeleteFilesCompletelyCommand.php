<?php


namespace App\Services\Files;


use App\Models\File;
use Illuminate\Database\Eloquent\Collection;

final class DeleteFilesCompletelyCommand
{
    protected DeleteFilesFromStorageCommand $deleteFromStorage;
    protected DeleteFilesFromDatabaseCommand $deleteFromDatabase;

    public function __construct(DeleteFilesFromStorageCommand $deleteFromStorage, DeleteFilesFromDatabaseCommand $deleteFromDatabase)
   {
       $this->deleteFromStorage = $deleteFromStorage;
       $this->deleteFromDatabase = $deleteFromDatabase;
   }

    /**
     * @param Collection|File[] $files
     */
    public function execute(Collection $files): void
    {
        $this->deleteFromDatabase->execute($files);
        $this->deleteFromStorage->execute($files);
    }
}
