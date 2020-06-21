<?php


namespace App\ValueObjects\DeletionDate;


final class NullDeletionDate implements DeletionDate
{
    private function __construct()
    {
    }

    public static function instance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new self();
        }

        return $instance;
    }

    public function toDateTimeString()
    {
        return '';
    }

    public function expired()
    {
        return false;
    }
}
