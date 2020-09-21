<?php

namespace App\Http\Resources\File;

use App\Http\Resources\LinkToken\LinkTokenIdentifierResource;
use App\Models\File;
use App\Models\FileLinkToken;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @mixin File
 * @OA\Schema(
 *      @OA\Property(
 *         property="links",
 *         @OA\Property(property="self", type="string", example="http://localhost:8000/api/files/1/relationships/link_tokens"),
 *         @OA\Property(property="related", type="string", example="http://localhost:8000/api/files/1/link_tokens"),
 *      ),
 *      @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/LinkTokenIdentifierResource")
 *      ),
 * ),
 */
final class FileLinkTokensRelationshipResource extends ResourceCollection
{
    protected File $file;

    /**
     * FileLinkTokensRelationshipResource constructor.
     * @param  Collection|FileLinkToken[]  $resource
     * @param  File  $parent
     */
    public function __construct(Collection $resource, File $parent)
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
                'self'    => route('api.files.relationships.link_tokens', [$this->file]),
                'related' => route('api.files.link_tokens.index', [$this->file])
            ],
            'data'  => LinkTokenIdentifierResource::collection($this->collection),
        ];
    }
}
