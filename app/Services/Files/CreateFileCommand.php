<?php


namespace App\Services\Files;


use App\DTO\Files\CreateFileDto;
use App\Events\Files\FileCreated;
use App\Models\File;
use Illuminate\Contracts\Events\Dispatcher;

class CreateFileCommand
{
    protected Dispatcher $dispatcher;
    protected FileSaver $filesUploader;

    public function __construct(Dispatcher $dispatcher, FileSaver $imageUploader)
    {
        $this->dispatcher = $dispatcher;
        $this->filesUploader = $imageUploader;
    }

    public function create(CreateFileDto $dto): File
    {
        $file = new File();

        $file->user_id = $dto->getUserId();
        $file->location = $this->filesUploader->upload($dto->getImage());
        $file->description = $dto->getDescription();
        $file->will_be_deleted_at = $dto->getDateToDelete();

        if ($file->save()) {
            $this->dispatcher->dispatch(new FileCreated($file->id));

            return $file;
        }
    }
}
