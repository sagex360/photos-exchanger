<?php


namespace App\Services\Files;


use App\DTO\Files\UpdateFileDto;
use App\Events\Files\FileUpdated;
use App\Exceptions\CouldNotSaveFileException;
use App\Models\File;
use Illuminate\Contracts\Events\Dispatcher;

final class UpdateFileCommand
{
    protected Dispatcher $dispatcher;

    /**
     * UpdateFileCommand constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param UpdateFileDto $updateFileDto
     * @return File
     * @throws CouldNotSaveFileException
     */
    public function execute(UpdateFileDto $updateFileDto): File
    {
        $file = $updateFileDto->getFile();

        $file->description = $updateFileDto->getDescription();
        $file->will_be_deleted_at = $updateFileDto->getDateToDelete();

        if ($file->save()) {
            $this->dispatcher->dispatch(new FileUpdated($file->id));

            return $file;
        }

        throw new CouldNotSaveFileException(trans('texts.dashboard.files.errors.update'));
    }
}
