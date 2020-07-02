<?php

namespace App\Casts;

use App\ValueObjects\Name;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

final class NameCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Name
     */
    public function get($model, string $key, $value, $attributes)
    {
        return Name::create($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param Name $setName
     * @param array $attributes
     * @return array
     */
    public function set($model, string $key, $setName, $attributes)
    {
        if (!$setName instanceof Name) {
            throw new InvalidArgumentException('Parameter $setName must be instance of ' . Name::class);
        }

        return [
            $key => $setName->value()
        ];
    }
}
