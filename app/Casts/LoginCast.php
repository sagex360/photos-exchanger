<?php

namespace App\Casts;

use App\ValueObjects\Login;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

final class LoginCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Login
     */
    public function get($model, string $key, $value, $attributes): Login
    {
        return Login::create($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param array $setLogin
     * @param array $attributes
     * @return array
     */
    public function set($model, string $key, $setLogin, $attributes): array
    {
        if (!$setLogin instanceof Login) {
            throw new InvalidArgumentException('Parameter $setLogin must be instance of ' . Login::class);
        }

        return [
            $key => $setLogin->value()
        ];
    }
}
