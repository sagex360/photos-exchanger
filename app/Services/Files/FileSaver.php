<?php


namespace App\Services\Files;


use App\ValueObjects\FileLocation\FileLocation;
use Illuminate\Filesystem\FilesystemManager;

use Illuminate\Http\UploadedFile;

final class FileSaver
{
    protected string $disk = 'local';

    protected FilesystemManager $filesystemManager;

    public function __construct(FilesystemManager $filesystemManager)
    {
        $this->filesystemManager = $filesystemManager;
    }

    public function upload(UploadedFile $file)
    {
        return FileLocation::in($this->disk, $file->hashName())
            ->saveTo($this->filesystemManager->disk($this->disk), $file);
    }
}
