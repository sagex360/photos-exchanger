<?php

namespace App\Http\Resources\File;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin File */
final class FileResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = false;

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $attributes = $this->getAttributes();

        return [
            'type'          => 'files',
            'id'            => $attributes['id'],
            'attributes'    => [
                'public_name'        => $attributes['public_name'],
                'description'        => $attributes['description'],
                'will_be_deleted_at' => $attributes['will_be_deleted_at'],
            ],
            'relationships' => [
                'user'        => new FileUserRelationshipResource($this->user, $this->resource),
                'link_tokens' => new FileLinkTokensRelationshipResource($this->linkTokens, $this->resource),
            ],
            'links'         => [
                'self'     => route('api.files.show', $this),
                'resource' => $this->location->url(),
            ],
        ];
    }
}
