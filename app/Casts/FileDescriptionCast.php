<?php

namespace App\Casts;

use App\ValueObjects\FileDescription;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

final class FileDescriptionCast implements CastsAttributes
{
    protected string $descriptionKey;
    protected string $publicNameKey;

    public function __construct(string $descriptionKey = 'description',
                                string $publicNameKey = 'public_name')
    {
        $this->descriptionKey = $descriptionKey;
        $this->publicNameKey = $publicNameKey;
    }

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
            $attributes[$this->publicNameKey],
            $attributes[$this->descriptionKey]
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model           $model
     * @param string          $key
     * @param FileDescription $fileDescription
     * @param array           $attributes
     * @return array
     */
    public function set($model, string $key, $fileDescription, $attributes)
    {
        if (!$fileDescription instanceof FileDescription) {
            throw new InvalidArgumentException('Parameter $setDescription must be instance of ' . FileDescription::class);
        }

        return [
            $this->publicNameKey  => $fileDescription->publicName(),
            $this->descriptionKey => $fileDescription->description(),
        ];
    }
}
