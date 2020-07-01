<?php

namespace App\Http\Resources\File;

use App\Http\Resources\LinkToken\LinkTokenIdentifierResource;
use App\Models\File;
use App\Models\FileLinkToken;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class FileLinkTokensRelationshipResource extends ResourceCollection
{
    /**
     * @var File
     */
    protected File $file;

    /**
     * FileLinkTokensRelationshipResource constructor.
     * @param Collection|FileLinkToken[] $resource
     * @param File                       $parent
     */
    public function __construct(Collection $resource, File $parent)
    {
        parent::__construct($resource);

        $this->file = $parent;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'links' => [
                'self'    => route('api.files.relationships.link_tokens', [$this->file]),
                'related' => route('api.files.link_tokens', [$this->file])
            ],
            'data'  => LinkTokenIdentifierResource::collection($this->collection),
        ];
    }
}
