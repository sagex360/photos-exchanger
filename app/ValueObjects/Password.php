<?php


namespace App\ValueObjects;


use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

final class Password
{
    public const MIN_LENGTH = 8;

    private string $hash;

    private function __construct(string $string, bool $isHashed)
    {
        if (!$isHashed) {
            if (mb_strlen($string) < self::MIN_LENGTH) {
                throw new InvalidArgumentException('Password must has at least '.self::MIN_LENGTH.' characters');
            }

            $string = Hash::make($string);
        }

        $this->hash = $string;
    }

    public static function create(string $rawPassword): Password
    {
        return new static($rawPassword, false);
    }

    public static function fromHash(string $hashedPassword): Password
    {
        return new static($hashedPassword, true);
    }

    public function hash(): string
    {
        return $this->hash;
    }

    public function __toString()
    {
        return $this->hash();
    }
}
