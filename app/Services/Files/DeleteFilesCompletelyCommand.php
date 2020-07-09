<?php


namespace App\Services\Files;


use App\Events\Files\FileDeleted;
use App\Models\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Events\Dispatcher;

final class DeleteFilesCompletelyCommand
{
    private DeleteFilesFromStorageCommand $deleteFromStorage;
    private DeleteFilesFromDatabaseCommand $deleteFromDatabase;
    private Dispatcher $dispatcher;

    public function __construct(
        DeleteFilesFromStorageCommand $deleteFromStorage,
        DeleteFilesFromDatabaseCommand $deleteFromDatabase,
        Dispatcher $dispatcher
    ) {
        $this->deleteFromStorage = $deleteFromStorage;
        $this->deleteFromDatabase = $deleteFromDatabase;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param  Collection|File[]  $files
     */
    public function execute(Collection $files): void
    {
        $this->deleteFromDatabase->execute($files);
        $this->deleteFromStorage->execute($files);

        foreach ($files as $file) {
            $this->dispatcher->dispatch(new FileDeleted($file->id));
        }
    }
}
