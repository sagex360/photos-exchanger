<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\Name;
use Illuminate\Support\Str;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function test_empty_name(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $name = Name::create('');
    }

    public function test_too_short_name(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $name = Name::create(Str::random(Name::MIN_LENGTH - 1));
    }

    public function test_successful_creation(): void
    {
        $name = Name::create('John Doe');

        self::assertSame('John Doe', $name->value());
    }
}
