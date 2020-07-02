<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\Name;
use Illuminate\Support\Str;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testEmptyName()
    {
        $this->expectException(InvalidArgumentException::class);
        $name = Name::create('');
    }

    public function testTooShortName()
    {
        $this->expectException(InvalidArgumentException::class);
        $name = Name::create(Str::random(Name::MIN_LENGTH - 1));
    }

    public function testSuccessfulCreation()
    {
        $name = Name::create('John Doe');

        $this->assertSame('John Doe', $name->value());
    }
}
