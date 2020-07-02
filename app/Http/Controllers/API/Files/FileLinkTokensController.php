<?php


namespace App\Http\Controllers\API\Files;


use App\Http\Controllers\Controller;
use App\Http\Resources\File\FileLinkTokensRelatedResource;
use App\Repositories\Files\FilesRepository;
use App\Repositories\FileTokens\FileTokensRepository;

final class FileLinkTokensController extends Controller
{
    /**
     * @var FilesRepository
     */
    protected FilesRepository $filesRepository;
    /**
     * @var FileTokensRepository
     */
    protected FileTokensRepository $tokensRepository;

    /**
     * FileLinkTokensController constructor.
     * @param FilesRepository      $filesRepository
     * @param FileTokensRepository $tokensRepository
     */
    public function __construct(FilesRepository $filesRepository, FileTokensRepository $tokensRepository)
    {
        $this->filesRepository = $filesRepository;
        $this->tokensRepository = $tokensRepository;
    }

    public function index(int $fileId)
    {
        return new FileLinkTokensRelatedResource(
            $this->tokensRepository->findByFileId($fileId),
            $this->filesRepository->findById($fileId)
        );
    }
}
