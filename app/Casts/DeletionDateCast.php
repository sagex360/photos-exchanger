<?php

namespace App\Casts;

use App\ValueObjects\DeletionDate\DeletionDate;
use App\ValueObjects\DeletionDate\DeletionDateFactory;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DeletionDateCast implements CastsAttributes
{
    protected string $dateFormat;

    public function __construct(string $dateFormat = 'Y-m-d H:i:s')
    {
        $this->dateFormat = $dateFormat;
    }

    /**
     * Cast the given value.
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     * @param array  $attributes
     * @return DeletionDate
     */
    public function get($model, string $key, $value, $attributes)
    {
        return DeletionDateFactory::fromFormat($this->dateFormat, $value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model        $model
     * @param string       $key
     * @param DeletionDate $setDate
     * @param array        $attributes
     * @return array
     */
    public function set($model, string $key, $setDate, $attributes)
    {
        if (!$setDate instanceof DeletionDate) {
            throw new \InvalidArgumentException('Parameter $setDate must be instance of ' . DeletionDate::class);
        }

        return [
            $key => $setDate->format($this->dateFormat)
        ];
    }
}
