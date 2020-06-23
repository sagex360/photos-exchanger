<?php


namespace App\ValueObjects;


final class FileDescription
{
    protected string $description;

    private function __construct(string $description)
    {
        $this->description = $description;
    }

    public static function create(string $description): self
    {
        return new static($description);
    }

    public function description(): string
    {
        return $this->description;
    }
}
