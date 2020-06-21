<?php

namespace App\Casts;

use App\ValueObjects\FileDescription;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class FileDescriptionCast implements CastsAttributes
{
    const REAL_NAME_KEY = 'real_name';
    const DESCRIPTION_KEY = 'description';

    /**
     * Cast the given value.
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     * @param array  $attributes
     * @return FileDescription
     */
    public function get($model, string $key, $value, $attributes)
    {
        return FileDescription::create(
            $attributes[self::REAL_NAME_KEY],
            $attributes[self::DESCRIPTION_KEY]
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model           $model
     * @param string          $key
     * @param FileDescription $setDescription
     * @param array           $attributes
     * @return array
     */
    public function set($model, string $key, $setDescription, $attributes)
    {
        if (!$setDescription instanceof FileDescription) {
            throw new InvalidArgumentException('Parameter $setDate must be instance of ' . FileDescription::class);
        }

        return [
            self::REAL_NAME_KEY   => $setDescription->realName(),
            self::DESCRIPTION_KEY => $setDescription->description()
        ];
    }
}
