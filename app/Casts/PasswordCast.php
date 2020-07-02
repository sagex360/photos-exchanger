<?php

namespace App\Casts;

use App\ValueObjects\Password;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Mockery\Generator\StringManipulation\Pass\Pass;

final class PasswordCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Password
     */
    public function get($model, string $key, $value, $attributes)
    {
        return Password::fromHash($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param array $setPassword
     * @param array $attributes
     * @return array
     */
    public function set($model, string $key, $setPassword, $attributes)
    {
        if (!$setPassword instanceof Password) {
            throw new InvalidArgumentException('Parameter $setPassword must be instance of ' . Pass::class);
        }

        return [
            $key => $setPassword->hash()
        ];
    }
}
