<?php


namespace App\ValueObjects;


use InvalidArgumentException;

final class Name
{
    public const MIN_LENGTH = 2;

    protected string $name;

    private function __construct(string $name)
    {
        if (mb_strlen($name) < self::MIN_LENGTH) {
            throw new InvalidArgumentException('Name must has at least ' . self::MIN_LENGTH . ' characters');
        }

        $this->name = $name;
    }

    public static function create(string $name): Name
    {
        return new static($name);
    }

    public function value(): string
    {
        return $this->name;
    }
}
