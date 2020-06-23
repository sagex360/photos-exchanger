<?php

namespace App\Casts;

use App\ValueObjects\FileLocation\FileLocation;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class FileLocationCast implements CastsAttributes
{
    protected string $storageKey;
    protected string $fileNameKey;

    public function __construct(string $storageKey = 'storage', string $fileNameKey = 'file_name')
    {
        $this->storageKey = $storageKey;
        $this->fileNameKey = $fileNameKey;
    }

    /**
     * Cast the given value.
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     * @param array  $attributes
     * @return FileLocation
     */
    public function get($model, string $key, $value, $attributes)
    {
        return FileLocation::in(
            $attributes[$this->storageKey],
            $attributes[$this->fileNameKey]
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model        $model
     * @param string       $key
     * @param FileLocation $setLocation
     * @param array        $attributes
     * @return array
     */
    public function set($model, string $key, $setLocation, $attributes)
    {
        if (!$setLocation instanceof FileLocation) {
            throw new InvalidArgumentException('Parameter $setLocation must be instance of ' . FileLocation::class);
        }

        return [
            $this->storageKey  => $setLocation->storage(),
            $this->fileNameKey => $setLocation->fileName(),
        ];
    }
}
