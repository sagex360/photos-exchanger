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
     *      summary="Get user id, which file belongs to.",
     *
     *      @OA\Parameter(
     *          name="Accept",
     *          description="Accept type",
     *          required=true,
     *          in="header",
     *          @OA\Schema(
     *              type="string",
     *              example="application/json",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Api authorization user token",
     *          required=true,
     *          in="header",
     *          @OA\Schema(
     *              type="string",
     *              example="Bearer 9194773b-3f24-42bb-93ca-654557dd303c",
     *          ),
     *      ),
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
     *          description="Authorization failed. Bearer token mismatch.",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="File with specified id not found.",
     *      ),
     * )
     *
     * @param int $fileId
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
     *      summary="Get all link token ids of file.",
     *      description="Retreive all link token ids by file id.",
     *
     *      @OA\Parameter(
     *          name="Accept",
     *          description="Accept type",
     *          required=true,
     *          in="header",
     *          @OA\Schema(
     *              type="string",
     *              example="application/json",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="Api authorization user token",
     *          required=true,
     *          in="header",
     *          @OA\Schema(
     *              type="string",
     *              example="Bearer 9194773b-3f24-42bb-93ca-654557dd303c",
     *          ),
     *      ),
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
     *          description="Authorization failed. Bearer token mismatch.",
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
     * @param  int  $fileId
     * @return FileLinkTokensRelationshipResource
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
