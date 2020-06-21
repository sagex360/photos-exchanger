<?php


namespace App\ValueObjects;


final class FileDescription
{
    protected string $realName;

    protected string $description;

    private function __construct(string $readName, string $description)
    {
        $this->realName = $readName;
        $this->description = $description;
    }

    public static function create(string $realName, string $description): self
    {
        return new static($realName, $description);
    }

    public function description(): string
    {
        return $this->description;
    }

    public function realName(): string
    {
        return $this->realName;
    }
}
