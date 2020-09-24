<?php

namespace App\Http\Controllers\API\LinkTokens;

use App\Http\Controllers\API\ApiController;
use App\Http\Resources\LinkToken\LinkTokenResource;
use App\Repositories\FileTokens\FileTokensRepository;
use App\ValueObjects\LinkToken\LinkTokensFactory;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * @OA\Tag(
 *     name="LinkTokens",
 *     description="This api provides access to file link tokens in system."
 * )
 * @OA\Parameter(
 *     parameter="link-token-path-parameter",
 *     name="linkToken",
 *     description="Generated token for visits.",
 *     required=true,
 *     in="path",
 *     @OA\Schema(
 *         type="string",
 *         example="9194e805-0408-4184-8ad1-22744d1ffe17ff",
 *     ),
 * ),
 */
final class LinkTokensController extends ApiController
{
    protected FileTokensRepository $tokensRepository;

    public function __construct(FileTokensRepository $tokensRepository)
    {
        $this->tokensRepository = $tokensRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/link_tokens/types",
     *      operationId="getSupportedLinkTokenTypes",
     *      tags={"LinkTokens"},
     *      summary="Get all supported token types.",
     *      security={
     *          { "bearer_auth": {} }
     *      },
     *      @OA\Parameter(ref="#/components/parameters/header-accept-type"),
     *      @OA\Parameter(ref="#/components/parameters/header-authorization-token"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful get operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Authentication failed. Bearer token mismatch.",
     *      ),
     * )
     *
     * @return array
     */
    public function types(): array
    {
        return LinkTokensFactory::supportedTypes();
    }

    /**
     * @OA\Get(
     *      path="/api/link_tokens/{link_token}",
     *      operationId="getLinkTokenById",
     *      tags={"LinkTokens"},
     *      summary="Get full information about link token by it's id.",
     *      security={
     *          { "bearer_auth": {} }
     *      },
     *      @OA\Parameter(ref="#/components/parameters/header-accept-type"),
     *      @OA\Parameter(ref="#/components/parameters/header-authorization-token"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful get.",
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
     *          description="Forbidden. You are not allowed to view this token.",
     *      ),
     * )
     *
     * @param int $id
     *
     * @return LinkTokenResource
     *
     * @throws AuthorizationException
     */
    public function show(int $id): LinkTokenResource
    {
        $token = $this->tokensRepository->findById($id);
        $this->authorize('view', $token);

        return new LinkTokenResource($token);
    }
}
