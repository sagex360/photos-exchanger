<?php

namespace App\Http\Resources\User;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Client
 * @OA\Schema(
 *      @OA\Property(property="type", type="string", example="users"),
 *      @OA\Property(property="id", type="integer", example="1"),
 *      @OA\Property(
 *         property="attributes",
 *         @OA\Property(property="name", type="string", example="John"),
 *         @OA\Property(property="email", type="string", example="hello-world@gmail.com"),
 *         @OA\Property(property="email_verified_at", type="string", nullable=true, format="date-time"),
 *      ),
 *      @OA\Property(
 *         property="links",
 *         @OA\Property(property="self", type="string", example="http://localhost:8000/api/users/1")
 *      ),
 * )
 *
 */
final class UserResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $attributes = $this->getAttributes();

        return [
            'type'       => 'users',
            'id'         => $this->id,
            'attributes' => [
                'name'              => $attributes['name'],
                'email'             => $attributes['email'],
                'email_verified_at' => $attributes['email_verified_at'],
            ],
            'links'      => [
                'self' => route('api.users.show', [$this]),
            ],
        ];
    }
}
