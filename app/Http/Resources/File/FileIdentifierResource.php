<?php


namespace App\Http\Resources\File;


use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin File */
final class FileIdentifierResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => 'files',
            'id'   => $this->id,
        ];
    }
}

