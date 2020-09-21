<?php


namespace App\Http\Controllers\API\Files;


use App\Exceptions\CouldNotSaveLinkTokenException;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Dashboard\Links\CreateLinkRequest;
use App\Http\Resources\File\FileLinkTokensRelatedResource;
use App\Http\Resources\LinkToken\LinkTokenResource;
use App\Models\FileLinkToken;
use App\Repositories\Files\FilesRepository;
use App\Repositories\FileTokens\FileTokensRepository;
use App\Services\LinkTokens\CreateLinkCommand;
use Illuminate\Auth\Access\AuthorizationException;

final class FileLinkTokensController extends ApiController
{
    protected FilesRepository $filesRepository;
    protected FileTokensRepository $tokensRepository;

    /**
     * FileLinkTokensController constructor.
     * @param  FilesRepository  $filesRepository
     * @param  FileTokensRepository  $tokensRepository
     */
    public function __construct(FilesRepository $filesRepository, FileTokensRepository $tokensRepository)
    {
        $this->filesRepository = $filesRepository;
        $this->tokensRepository = $tokensRepository;
    }

    /**
     * @param  int  $fileId
     * @return FileLinkTokensRelatedResource
     * @throws AuthorizationException
     */
    public function index(int $fileId): FileLinkTokensRelatedResource
    {
        $file = $this->filesRepository->findById($fileId);
        $this->authorize('viewAnyOf', [FileLinkToken::class, $file]);

        return new FileLinkTokensRelatedResource(
            $this->tokensRepository->findByFileId($fileId),
            $file
        );
    }

    /**
     * @param  int  $fileId
     * @param  CreateLinkRequest  $request
     * @param  CreateLinkCommand  $command
     * @return LinkTokenResource
     * @throws CouldNotSaveLinkTokenException
     * @throws AuthorizationException
     */
    public function store(int $fileId, CreateLinkRequest $request, CreateLinkCommand $command): LinkTokenResource
    {
        $file = $this->filesRepository->findById($fileId);
        $this->authorize('createOf', [FileLinkToken::class, $file]);

        $linkToken = $command->execute($request->makeDto($file));

        return new LinkTokenResource($linkToken);
    }
}
