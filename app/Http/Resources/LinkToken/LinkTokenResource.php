<?php

namespace App\Http\Resources\LinkToken;

use App\Models\FileLinkToken;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin FileLinkToken */
class LinkTokenResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
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
