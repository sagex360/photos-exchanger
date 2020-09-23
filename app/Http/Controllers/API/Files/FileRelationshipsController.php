<?php

namespace App\Http\Controllers\API\Files;

use App\Http\Controllers\API\ApiController;
use App\Http\Resources\File\FileLinkTokensRelationshipResource;
use App\Http\Resources\File\FileUserRelationshipResource;
use App\Models\FileLinkToken;
use App\Repositories\Files\FilesRepository;
use App\Repositories\FileTokens\FileTokensRepository;
use App\Repositories\Users\UsersRepository;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * @OA\Tag(
 *     name="FileRelationships",
 *     description="This api provides access to file relationships in the system."
 * )
 */
final class FileRelationshipsController extends ApiController
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

    /**
     * @OA\Get(
     *      path="/api/files/{fileId}/relationships/user",
     *      operationId="getFileUserRelationship",
     *      tags={"FileRelationships","Users"},
     *      summary="Retreive link and user id, which file belongs to.",
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
     *      @OA\Response(
     *          response=200,
     *          description="Successful get operation",
     *          @OA\JsonContent(ref="#/components/schemas/FileUserRelationshipResource")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Authentication failed. Bearer token mismatch.",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="File with specified id not found.",
     *      ),
     * )
     *
     * @param int $fileId
     *
     * @return FileUserRelationshipResource
     */
    public function user(int $fileId): FileUserRelationshipResource
    {
        return new FileUserRelationshipResource(
            $this->usersRepository->findByFileId($fileId),
            $this->filesRepository->findById($fileId),
        );
    }

    /**
     * @OA\Get(
     *      path="/api/files/{fileId}/relationships/link_tokens",
     *      operationId="getFileLinkTokensRelationship",
     *      tags={"FileRelationships", "LinkTokens"},
     *      summary="Get all link token ids related to provided file.",
     *      description="Retreive all link token ids by file id.",
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
     *      @OA\Response(
     *          response=200,
     *          description="Successful get operation",
     *          @OA\JsonContent(ref="#/components/schemas/FileLinkTokensRelationshipResource")
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
     * @return FileLinkTokensRelationshipResource
     *
     * @throws AuthorizationException
     */
    public function linkTokens(int $fileId): FileLinkTokensRelationshipResource
    {
        $file = $this->filesRepository->findById($fileId);
        $this->authorize('viewAnyOf', [FileLinkToken::class, $file]);

        return new FileLinkTokensRelationshipResource(
            $this->tokensRepository->findByFileId($fileId),
            $file,
        );
    }
}
