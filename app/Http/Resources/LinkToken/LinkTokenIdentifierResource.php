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
 * )
 */
final class LinkTokenIdentifierResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => 'link_tokens',
            'id'   => $this->id,
        ];
    }
}
