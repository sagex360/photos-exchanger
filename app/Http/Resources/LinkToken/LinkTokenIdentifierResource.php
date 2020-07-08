<?php

namespace App\Http\Resources\LinkToken;

use App\Models\FileLinkToken;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin FileLinkToken */
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
