<?php

namespace App\Http\Resources\LinkToken;

use App\Models\FileLinkToken;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin FileLinkToken
 * @OA\Schema(
 *      @OA\Property(property="type", type="string", example="link_tokens"),
 *      @OA\Property(property="id", type="integer", example="1"),
 *      @OA\Property(
 *         property="attributes",
 *         @OA\Property(property="token", type="string", example="9194e805-0408-4184-8ad1-22744d1ffe17"),
 *         @OA\Property(property="type", type="string", enum={"disposable", "unlimited"}),
 *         @OA\Property(property="created_at", type="string", format="date-time"),
 *         @OA\Property(property="updated_at", type="string", format="date-time"),
 *      ),
 *      @OA\Property(
 *         property="links",
 *         @OA\Property(property="self", type="string", example="http://localhost:8000/api/link_tokens/1"),
 *         @OA\Property(property="resource", type="string", example="http://localhost:8000/api/guest/files/9194e805-0408-4184-8ad1-22744d1ffe17"),
 *      ),
 * )
 */
final class LinkTokenResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $attributes = $this->getAttributes();

        return [
            'type' => 'link_tokens',
            'id'   => $this->id,

            'attributes' => [
                'token'      => $attributes['token'],
                'type'       => $attributes['type'],
                'created_at' => $attributes['created_at'],
                'updated_at' => $attributes['updated_at'],
            ],

            'links' => [
                'self'     => route('api.link_tokens.show', [$this]),
                'resource' => route('api.guest.files.resource', [$this->token->token()]),
            ]
        ];
    }
}
