<?php

namespace App\Http\Resources\File;

use App\Http\Resources\User\UserIdentifierResource;
use App\Models\Client;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Client
 * @OA\Schema(
 *      @OA\Property(
 *         property="links",
 *         @OA\Property(property="self", type="string", example="http://localhost:8000/api/files/1/relationships/user"),
 *         @OA\Property(property="related", type="string", example="http://localhost:8000/api/users/1"),
 *      ),
 *      @OA\Property(
 *         property="data",
 *         ref="#/components/schemas/UserIdentifierResource"
 *      ),
 * )
 */
final class FileUserRelationshipResource extends JsonResource
{
    protected File $file;

    public function __construct(Client $resource, File $parent)
    {
        parent::__construct($resource);

        $this->file = $parent;
    }

    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'links' => [
                'self'    => route('api.files.relationships.user', [$this->file]),
                'related' => route('api.users.show', [$this->resource])
            ],
            'data'  => new UserIdentifierResource($this->resource),
        ];
    }
}
