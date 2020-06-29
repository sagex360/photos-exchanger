<?php

namespace App\Http\Controllers\API;

use App\Exceptions\FileTokenExpiredException;
use App\Http\Controllers\Controller;
use App\Repositories\Files\FilesRepository;
use App\Repositories\FileTokens\FileTokensRepository;
use App\Services\Files\DeleteFilesCompletelyCommand;
use App\Services\Files\RecordLinkVisitCommand;
use App\Services\Files\VerifyFileLinkCommand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int                          $id
     * @param DeleteFilesCompletelyCommand $command
     * @return void
     */
    public function destroy(int $id, DeleteFilesCompletelyCommand $command)
    {
        $command->execute(Collection::make($this->filesRepository->findWithTokens($id)));
    }

    /**
     * @param string                 $token
     * @param VerifyFileLinkCommand  $verifyLink
     * @param RecordLinkVisitCommand $recordLinkVisit
     * @param FilesystemManager      $filesystemManager
     * @return string
     * @throws FileTokenExpiredException
     */
    public function link(string $token, VerifyFileLinkCommand $verifyLink, RecordLinkVisitCommand $recordLinkVisit, FilesystemManager $filesystemManager)
    {
        $fileLinkToken = $this->fileTokensRepository->find($token);

        $verifyLink->execute($fileLinkToken);
        $recordLinkVisit->execute($fileLinkToken);

        return $filesystemManager->disk($fileLinkToken->file->location->storage())
            ->response($fileLinkToken->file->location->fullPath());
    }
}
