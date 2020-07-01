<?php

namespace App\Http\Resources\File;

use App\Http\Resources\User\UserIdentifierResource;
use App\Models\Client;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Client */
class FileUserRelationshipResource extends JsonResource
{
    /**
     * @var File
     */
    protected File $file;

    public function __construct(Client $resource, File $parent)
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
                'self'    => route('api.files.relationships.user', [$this->file]),
                'related' => route('api.users.show', [$this->resource])
            ],
            'data'  => new UserIdentifierResource($this->resource),
        ];
    }
}
