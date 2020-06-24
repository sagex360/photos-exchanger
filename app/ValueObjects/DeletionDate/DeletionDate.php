<?php


namespace App\ValueObjects\DeletionDate;

interface DeletionDate
{
    public function expired(): bool;

    public function format(string $format): ?string;

    public function readable(): ?string;
}
