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
     *
     * @param FilesRepository      $filesRepository
     * @param FileTokensRepository $tokensRepository
     */
    public function __construct(FilesRepository $filesRepository, FileTokensRepository $tokensRepository)
    {
        $this->filesRepository = $filesRepository;
        $this->tokensRepository = $tokensRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/files/{fileId}/link_tokens",
     *      operationId="getFileLinkTokens",
     *      tags={"FileRelationships", "LinkTokens"},
     *      summary="Get all link tokens of file.",
     *      description="Retreive all link tokens by file id.",
     *      @OA\Parameter(ref="#/components/parameters/header-accept-type"),
     *      @OA\Parameter(ref="#/components/parameters/header-authorization-token"),
     *      @OA\Parameter(
     *          name="fileId",
     *          description="File id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              example="1",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful get operation",
     *          @OA\JsonContent(ref="#/components/schemas/FileLinkTokensRelatedResource")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Authentication failed. Bearer token mismatch.",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden. Probably you are trying to access link tokens of not your file.",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="File with specified id not found.",
     *      ),
     * )
     *
     * @param int $fileId
     *
     * @return FileLinkTokensRelatedResource
     *
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
     * @OA\Post(
     *      path="/api/files/{fileId}/link_tokens",
     *      operationId="storeNewFile",
     *      tags={"FileRelationships", "LinkTokens"},
     *      summary="Store new file.",
     *      description="Put file to storage and save it's information to database.",
     *
     *      @OA\Parameter(ref="#/components/parameters/header-accept-type"),
     *      @OA\Parameter(ref="#/components/parameters/header-authorization-token"),
     *      @OA\Parameter(
     *          name="fileId",
     *          description="File id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              example="1",
     *          ),
     *      ),
     *      @OA\RequestBody(ref="#/components/requestBodies/create-link-token-request-body"),
     *      @OA\Response(
     *          response=200,
     *          description="Link token was successfully created.",
     *          @OA\JsonContent(
     *              @OA\Property (
     *                  property="data",
     *                  ref="#/components/schemas/LinkTokenResource",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Authentication failed. Bearer token mismatch.",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden. You are not allowed to create link tokens for this file.",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity. Given data is invalid.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example="{""link_type"": [ ""The selected link type is invalid."" ]}"),
     *          )
     *      ),
     * )
     *
     * @param int               $fileId
     * @param CreateLinkRequest $request
     * @param CreateLinkCommand $command
     *
     * @return LinkTokenResource
     *
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
