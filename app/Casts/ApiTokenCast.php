<?php

namespace App\Casts;

use App\ValueObjects\ApiToken;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

final class ApiTokenCast implements CastsAttributes
{
    private string $tokenKey;

    /**
     * ApiTokenCast constructor.
     * @param  string  $tokenKey
     */
    public function __construct(string $tokenKey = 'api_token')
    {
        $this->tokenKey = $tokenKey;
    }

    /**
     * Cast the given value.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return ApiToken
     */
    public function get($model, string $key, $value, $attributes): ApiToken
    {
        return ApiToken::create(
            $attributes[$this->tokenKey]
        );
    }


    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  ApiToken  $value
     * @param  array  $attributes
     * @return array
     */
    public function set($model, string $key, $value, $attributes): array
    {
        if (!$value instanceof ApiToken) {
            throw new InvalidArgumentException('Could not cast '.\get_class($value).' to '.ApiToken::class);
        }

        return [
            $this->tokenKey => $value->token()
        ];
    }
}
