<?php

namespace App\Http\Resources\User;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Client */
class UserIdentifierResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'users',
            'id'   => $this->id,
        ];
    }
}
