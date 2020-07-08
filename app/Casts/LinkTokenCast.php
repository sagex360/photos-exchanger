<?php

namespace App\Casts;

use App\Models\FileLinkToken;
use App\ValueObjects\LinkToken\LinkToken;
use App\ValueObjects\LinkToken\LinkTokensFactory;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class LinkTokenCast implements CastsAttributes
{
    protected string $tokenKey;
    protected string $tokenTypeKey;

    public function __construct(string $tokenKey = 'token', string $tokenTypeKey = 'type')
    {
        $this->tokenKey = $tokenKey;
        $this->tokenTypeKey = $tokenTypeKey;
    }

    /**
     * Cast the given value.
     *
     * @param  FileLinkToken  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return LinkToken
     */
    public function get($model, string $key, $value, $attributes): LinkToken
    {
        return LinkTokensFactory::create(
            $attributes[$this->tokenTypeKey],
            $attributes[$this->tokenKey],
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  LinkToken  $value
     * @param  array  $attributes
     * @return array
     */
    public function set($model, string $key, $value, $attributes): array
    {
        return [
            $this->tokenKey     => $value->token(),
            $this->tokenTypeKey => $value->type(),
        ];
    }
}
