<?php


namespace App\Services\Files;


use App\DTO\Files\UpdateFileDto;
use App\Events\Files\FileUpdated;
use App\Exceptions\CouldNotSaveFileException;
use App\Models\File;
use App\Repositories\Files\FilesRepository;
use Illuminate\Contracts\Events\Dispatcher;

final class UpdateFileCommand
{
    /**
     * @var FilesRepository
     */
    protected FilesRepository $filesRepository;
    /**
     * @var Dispatcher
     */
    protected Dispatcher $dispatcher;

    /**
     * UpdateFileCommand constructor.
     * @param FilesRepository $filesRepository
     * @param Dispatcher      $dispatcher
     */
    public function __construct(FilesRepository $filesRepository, Dispatcher $dispatcher)
    {
        $this->filesRepository = $filesRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param UpdateFileDto $updateFileDto
     * @return File
     * @throws CouldNotSaveFileException
     */
    public function execute(UpdateFileDto $updateFileDto): File
    {
        $file = $this->filesRepository->findWithTokens($updateFileDto->getId());

        $file->description = $updateFileDto->getDescription();
        $file->will_be_deleted_at = $updateFileDto->getDateToDelete();

        if ($file->save()) {
            $this->dispatcher->dispatch(new FileUpdated($file->id));

            return $file;
        }

        throw new CouldNotSaveFileException(trans('texts.dashboard.files.errors.update'));
    }
}
