<?php

namespace App\Http\Controllers\API\Files;

use App\Http\Controllers\Controller;
use App\Http\Resources\File\FileLinkTokensRelationshipResource;
use App\Http\Resources\File\FileUserRelationshipResource;
use App\Repositories\Files\FilesRepository;
use App\Repositories\FileTokens\FileTokensRepository;
use App\Repositories\Users\UsersRepository;

final class FileRelationshipsController extends Controller
{
    protected UsersRepository $usersRepository;
    protected FilesRepository $filesRepository;
    protected FileTokensRepository $tokensRepository;

    public function __construct(
        UsersRepository $usersRepository,
        FilesRepository $filesRepository,
        FileTokensRepository $tokensRepository
    ) {
        $this->usersRepository = $usersRepository;
        $this->filesRepository = $filesRepository;
        $this->tokensRepository = $tokensRepository;
    }

    public function user(int $fileId): FileUserRelationshipResource
    {
        return new FileUserRelationshipResource(
            $this->usersRepository->findByFileId($fileId),
            $this->filesRepository->findById($fileId),
        );
    }

    public function linkTokens(int $fileId): FileLinkTokensRelationshipResource
    {
        return new FileLinkTokensRelationshipResource(
            $this->tokensRepository->findByFileId($fileId),
            $this->filesRepository->findById($fileId),
        );
    }
}
