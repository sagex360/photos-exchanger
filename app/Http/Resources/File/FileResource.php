<?php

namespace App\Http\Resources\File;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin File
 * @OA\Schema(
 *      @OA\Property(property="type", type="string", example="files"),
 *      @OA\Property(property="id", type="integer", example="1"),
 *      @OA\Property(
 *         property="attributes",
 *         @OA\Property(property="public_name", type="string", example="Some name"),
 *         @OA\Property(property="description", type="string", example="Sensitive Description"),
 *         @OA\Property(property="will_be_deleted_at", type="string", nullable=true, format="date-time"),
 *      ),
 *      @OA\Property(
 *         property="relationships",
 *         @OA\Property(
 *              property="user",
 *              ref="#/components/schemas/FileUserRelationshipResource"
 *         ),
 *         @OA\Property(
 *              property="link_tokens",
 *              ref="#/components/schemas/FileLinkTokensRelationshipResource",
 *         ),
 *      ),
 *      @OA\Property(
 *         property="links",
 *         @OA\Property(property="self", type="string", example="http://localhost:8000/api/files/1"),
 *         @OA\Property(property="resource", type="string", example="http://localhost:8000/storage/uploads/files/qCgqGAf88xif2IHR7ElLHSlaTqLmqMJdjFzBw3LB.png"),
 *      ),
 * )
 */
final class FileResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = false;

    /**
     * @param  Request  $request
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
