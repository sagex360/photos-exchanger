<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\User\UserResource;
use App\Repositories\Users\UsersRepository;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="API Endpoints of Users"
 * )
 * @OA\Parameter(
 *     parameter="user-id-path-parameter",
 *     name="userId",
 *     description="User id",
 *     required=true,
 *     in="path",
 *     @OA\Schema(
 *         type="integer",
 *         example="1",
 *     ),
 * ),
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
     *      @OA\Parameter(ref="#/components/parameters/header-accept-type"),
     *      @OA\Parameter(ref="#/components/parameters/header-authorization-token"),
     *      @OA\Parameter(ref="#/components/parameters/user-id-path-parameter"),
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
     *
     * @param int $id
     *
     * @return UserResource
     */
    public function show(int $id): UserResource
    {
        return new UserResource($this->usersRepository->findById($id));
    }
}
