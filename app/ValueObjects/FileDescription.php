<?php


namespace App\ValueObjects;


use Illuminate\Support\Str;
use InvalidArgumentException;

final class FileDescription
{
    public const MIN_PUBLIC_NAME = 1;
    public const MIN_DESCRIPTION = 1;

    public const MAX_PUBLIC_NAME = 255;
    public const MAX_DESCRIPTION = 65535;

    public const SHORT_DESCRIPTION_LIMIT = 50;

    protected string $publicName;
    protected string $description;

    private function __construct(string $publicName, string $description)
    {
        $nameLength = mb_strlen($publicName);

        if ($nameLength < self::MIN_PUBLIC_NAME) {
            throw new InvalidArgumentException('Name must be at least ' . self::MIN_PUBLIC_NAME . ' characters');
        }

        if ($nameLength > self::MAX_PUBLIC_NAME) {
            throw new InvalidArgumentException('Name could not be more than ' . self::MAX_PUBLIC_NAME . ' characters');
        }

        $descriptionLength = mb_strlen($description);

        if ($descriptionLength < self::MIN_DESCRIPTION) {
            throw new InvalidArgumentException('Description must be at least ' . self::MIN_DESCRIPTION . ' characters');
        }

        if ($descriptionLength > self::MAX_DESCRIPTION) {
            throw new InvalidArgumentException('Description could not be more than ' . self::MAX_DESCRIPTION . ' characters');
        }

        $this->publicName = $publicName;
        $this->description = $description;
    }

    public static function create(string $publicName, string $description): self
    {
        return new static($publicName, $description);
    }

    public function description(): string
    {
        return $this->description;
    }

    public function publicName(): string
    {
        return $this->publicName;
    }

    public function shortDescription(): string
    {
        return Str::limit($this->description(), self::SHORT_DESCRIPTION_LIMIT, '...');
    }
}
