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
 * )
 */
final class FileIdentifierResource extends JsonResource
{
    /**
     * @param  Request  $request
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

