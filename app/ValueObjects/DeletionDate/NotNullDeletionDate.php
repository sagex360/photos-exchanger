<?php


namespace App\ValueObjects\DeletionDate;


use Carbon\CarbonInterface as Carbon;

final class NotNullDeletionDate implements DeletionDate
{
    protected Carbon $date;

    /**
     * NotNullDeletionDate constructor.
     * @param Carbon $date
     */
    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    public function expired()
    {
        return !$this->date->isAfter($this->date::now());
    }

    public function toDateTimeString()
    {
        return $this->date->toDateTimeString();
    }
}
