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
     * @param  int  $id
     * @return LinkTokenResource
     * @throws AuthorizationException
     */
    public function show(int $id): LinkTokenResource
    {
        $token = $this->tokensRepository->findById($id);
        $this->authorize('view', $token);

        return new LinkTokenResource($token);
    }
}
