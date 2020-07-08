<?php

namespace App\Http\Resources\User;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Client */
final class UserResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $attributes = $this->getAttributes();

        return [
            'type'       => 'users',
            'id'         => $this->id,
            'attributes' => [
                'name'              => $attributes['name'],
                'email'             => $attributes['email'],
                'email_verified_at' => $attributes['email_verified_at'],
            ],
            'links'      => [
                'self' => route('api.users.show', [$this]),
            ],
        ];
    }
}
