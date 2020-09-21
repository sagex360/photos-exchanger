<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\User\UserResource;
use App\Repositories\Users\UsersRepository;


/**
 * @OA\Tag(
 *     name="Users",
 *     description="API Endpoints of Users"
 * )
 */
final class UsersController extends ApiController
{
    protected UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/users/{userId}",
     *      operationId="getUserById",
     *      tags={"Users"},
     *      summary="Get single user by id",
     *      description="Returns user information",
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
     *          name="userId",
     *          description="User id",
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
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="User with specified id not found.",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Authentication failed. Bearer token mismatch.",
     *      ),
     * )
     * @param  int  $id
     * @return UserResource
     */
    public function show(int $id): UserResource
    {
        return new UserResource($this->usersRepository->findById($id));
    }
}
