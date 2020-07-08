<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\Name;
use Illuminate\Support\Str;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $name = Name::create('');
    }

    public function testTooShortName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $name = Name::create(Str::random(Name::MIN_LENGTH - 1));
    }

    public function testSuccessfulCreation(): void
    {
        $name = Name::create('John Doe');

        self::assertSame('John Doe', $name->value());
    }
}
