<?php


namespace App\ValueObjects\DeletionDate;


use Illuminate\Support\Carbon;

final class IlluminateCarbonDeletionDateFactory
{
    public function at(Carbon $date): DeletionDate
    {
        return new NotNullDeletionDate($date);
    }

    public function fromFormat(string $format, ?string $time, $zone = null): DeletionDate
    {
        if ($time === null || $time === '') {
            return NullDeletionDate::instance();
        }

        return new NotNullDeletionDate(Carbon::createFromFormat($format, $time, $zone));
    }
}
