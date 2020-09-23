<?php

namespace App\Http\Controllers\API\Files;

use App\Exceptions\CouldNotSaveFileException;
use App\Exceptions\FileTokenExpiredException;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Dashboard\Files\StoreFileRequest;
use App\Http\Resources\File\FileIdentifierResource;
use App\Http\Resources\File\FileResource;
use App\Models\File;
use App\Repositories\Files\FilesRepository;
use App\Repositories\FileTokens\FileTokensRepository;
use App\Services\Files\CreateFileCommand;
use App\Services\Files\DeleteFilesCompletelyCommand;
use App\Services\Files\ReceiveFileFromStorageCommand;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @OA\Tag(
 *     name="Files",
 *     description="This api provides access to files (photos) in system."
 * )
 */
final class FilesController extends ApiController
{
    protected FilesRepository $filesRepository;
    protected FileTokensRepository $fileTokensRepository;

    public function __construct(FilesRepository $filesRepository, FileTokensRepository $fileTokensRepository)
    {
        $this->filesRepository = $filesRepository;
        $this->fileTokensRepository = $fileTokensRepository;
    }

    /**
     * @OA\Post(
     *      path="/api/files/",
     *      operationId="storeNewFile",
     *      tags={"Files"},
     *      summary="Store new file.",
     *      description="Put file to storage and save it's information to database.",
     *
     *      @OA\Parameter(ref="#/components/parameters/header-accept-type"),
     *      @OA\Parameter(ref="#/components/parameters/header-authorization-token"),
     *      @OA\RequestBody(ref="#/components/requestBodies/store-file-request-body"),
     *      @OA\Response(
     *          response=200,
     *          description="File was successfully inserted.",
     *          @OA\JsonContent(
     *              @OA\Property (
     *                  property="data",
     *                  ref="#/components/schemas/FileIdentifierResource",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Authentication failed. Bearer token mismatch.",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden. You are not allowed to create files.",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity. Given data is invalid.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example="{""file"": [ ""The file field is required."" ]}"),
     *          )
     *      ),
     * )
     *
     * @param StoreFileRequest  $request
     * @param CreateFileCommand $command
     *
     * @return FileIdentifierResource
     *
     * @throws CouldNotSaveFileException
     * @throws AuthorizationException
     */
    public function store(StoreFileRequest $request, CreateFileCommand $command): FileIdentifierResource
    {
        $this->authorize('create', File::class);

        $file = $command->create($request->createDto());

        return new FileIdentifierResource($file);
    }

    /**
     * @OA\Get(
     *      path="/api/files/{fileId}",
     *      operationId="getFileById",
     *      tags={"Files"},
     *      summary="Get file by id",
     *      description="Access file database information by it's id",
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
     *          @OA\JsonContent(ref="#/components/schemas/FileResource")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Authentication failed. Bearer token mismatch.",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden. You are not allowed to access this file.",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="File with specified id not found.",
     *      ),
     * )
     *
     * @param int $id
     *
     * @return FileResource
     *
     * @throws AuthorizationException
     */
    public function show(int $id): FileResource
    {
        $file = $this->filesRepository->findById($id);
        $this->authorize('view', $file);

        return new FileResource($file);
    }

    /**
     * @OA\Delete (
     *      path="/api/files/{fileId}",
     *      operationId="deleteFileById",
     *      tags={"Files"},
     *      summary="Delete file by id.",
     *      description="Delete file from storage and it's information from database. Returns resource of deleted file.",
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
     *          description="Successful delete operation. Return deleted file response.",
     *          @OA\JsonContent(ref="#/components/schemas/FileResource")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Authentication failed. Bearer token mismatch.",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden. Probably you are trying to delete not your file.",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="File with specified id not found.",
     *      ),
     * )
     *
     * @param int                          $id
     * @param DeleteFilesCompletelyCommand $command
     *
     * @return FileResource
     *
     * @throws AuthorizationException
     */
    public function destroy(int $id, DeleteFilesCompletelyCommand $command): FileResource
    {
        $file = $this->filesRepository->findById($id);
        $this->authorize('delete', $file);

        $command->execute(Collection::wrap($file));

        return new FileResource($file);
    }

    /**
     * @OA\Get(
     *      path="/api/guest/files/{linkToken}",
     *      operationId="getFileResourceByLinkToken",
     *      tags={"Files"},
     *      summary="Get file resource by it's link token.",
     *      description="Retreive file from storage, record it's visit, return file binary resource.",
     *
     *      @OA\Parameter(
     *          name="linkToken",
     *          description="Generated token for visits.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              example="9194e805-0408-4184-8ad1-22744d1ffe17ff",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful get operation. Returns streamed file response.",
     *          @OA\MediaType(
     *              mediaType="binary"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="File with provided link token not found.",
     *      ),
     * )
     *
     * @param string                        $token
     * @param ReceiveFileFromStorageCommand $fileStorage
     *
     * @return StreamedResponse
     *
     * @throws FileTokenExpiredException
     */
    public function fileResource(string $token, ReceiveFileFromStorageCommand $fileStorage): StreamedResponse
    {
        $fileLinkToken = $this->fileTokensRepository->findByToken($token);

        return $fileStorage->get($fileLinkToken);
    }
}
