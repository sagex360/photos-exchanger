<?php


namespace App\ValueObjects\DeletionDate;

interface DeletionDate
{
    public function expired();

    public function toDateTimeString();
}
