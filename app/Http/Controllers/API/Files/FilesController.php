<?php

namespace App\Http\Controllers\API\Files;

use App\Exceptions\CouldNotSaveFileException;
use App\Exceptions\FileTokenExpiredException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Files\StoreFileRequest;
use App\Http\Resources\File\FileIdentifierResource;
use App\Http\Resources\File\FileResource;
use App\Models\File;
use App\Repositories\Files\FilesRepository;
use App\Repositories\FileTokens\FileTokensRepository;
use App\Services\Files\CreateFileCommand;
use App\Services\Files\DeleteFilesCompletelyCommand;
use App\Services\Files\RecordLinkVisitCommand;
use App\Services\Files\VerifyFileLinkCommand;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Filesystem\FilesystemManager;

final class FilesController extends Controller
{
    /**
     * @var FilesRepository
     */
    protected FilesRepository $filesRepository;
    /**
     * @var FileTokensRepository
     */
    protected FileTokensRepository $fileTokensRepository;

    public function __construct(FilesRepository $filesRepository, FileTokensRepository $fileTokensRepository)
    {
        $this->filesRepository = $filesRepository;
        $this->fileTokensRepository = $fileTokensRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFileRequest  $request
     * @param CreateFileCommand $command
     * @return FileIdentifierResource
     * @throws CouldNotSaveFileException
     * @throws AuthorizationException
     */
    public function store(StoreFileRequest $request, CreateFileCommand $command)
    {
        $this->authorize('create', File::class);

        $file = $command->create($request->createDto());

        return new FileIdentifierResource($file);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return FileResource
     * @throws AuthorizationException
     */
    public function show(int $id)
    {
        $file = $this->filesRepository->findById($id);
        $this->authorize('view', $file);

        return new FileResource($file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int                          $id
     * @param DeleteFilesCompletelyCommand $command
     * @return FileResource
     * @throws AuthorizationException
     */
    public function destroy(int $id, DeleteFilesCompletelyCommand $command)
    {
        $file = $this->filesRepository->findById($id);
        $this->authorize('delete', $file);

        $command->execute(Collection::wrap($file));

        return new FileResource($file);
    }

    /**
     * @param string                 $token
     * @param VerifyFileLinkCommand  $verifyLink
     * @param RecordLinkVisitCommand $recordLinkVisit
     * @param FilesystemManager      $filesystemManager
     * @return string
     * @throws FileTokenExpiredException
     */
    public function fileResource(string $token, VerifyFileLinkCommand $verifyLink, RecordLinkVisitCommand $recordLinkVisit, FilesystemManager $filesystemManager)
    {
        $fileLinkToken = $this->fileTokensRepository->findByToken($token);

        $verifyLink->execute($fileLinkToken);
        $recordLinkVisit->execute($fileLinkToken);

        return $filesystemManager->disk($fileLinkToken->file->location->storage())
            ->response($fileLinkToken->file->location->fullPath());
    }
}
