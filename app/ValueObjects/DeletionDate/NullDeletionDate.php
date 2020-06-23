<?php


namespace App\ValueObjects\DeletionDate;


final class NullDeletionDate implements DeletionDate
{
    private function __construct()
    {
    }

    public static function instance(): self
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new self();
        }

        return $instance;
    }

    public function format(string $format): ?string
    {
        return null;
    }

    public function expired(): bool
    {
        return false;
    }
}
