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
 * )
 */
final class UserIdentifierResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => 'users',
            'id'   => $this->id,
        ];
    }
}
