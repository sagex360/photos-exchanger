<?php


namespace App\Services\Files;


use App\Models\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Filesystem\FilesystemManager;

final class DeleteFilesFromStorageCommand
{
    protected FilesystemManager $filesystemManager;

    public function __construct(FilesystemManager $filesystemManager)
    {
        $this->filesystemManager = $filesystemManager;
    }

    /**
     * @param  Collection|File[]  $files
     */
    public function execute(Collection $files): void
    {
        foreach ($files as $file) {
            $file->location->destroy($this->filesystemManager);
        }
    }
}
