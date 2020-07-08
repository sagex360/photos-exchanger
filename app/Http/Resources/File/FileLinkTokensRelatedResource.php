<?php

namespace App\Http\Resources\File;

use App\Http\Resources\LinkToken\LinkTokenResource;
use App\Models\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class FileLinkTokensRelatedResource extends ResourceCollection
{
    protected File $file;

    public function __construct(Collection $resource, File $parent)
    {
        parent::__construct($resource);
        $this->file = $parent;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data'  => LinkTokenResource::collection($this->collection),
            'links' => [
                'self' => route('api.files.link_tokens.index', [$this->file])
            ],
        ];
    }
}
