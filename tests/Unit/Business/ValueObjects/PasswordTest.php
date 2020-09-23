<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    public function test_empty_password(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $password = Password::create('');
    }

    public function test_too_short_password(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $password = Password::create(Str::random(Password::MIN_LENGTH - 1));
    }

    public function test_successful_creation(): void
    {
        $password = Password::create('12345678');

        self::assertSame($password->hash(), (string) $password);
    }

    public function test_creation_from_hash(): void
    {
        $hashedPassword = Hash::make('my_password');

        $password = Password::fromHash($hashedPassword);

        self::assertEquals($password->hash(), $hashedPassword);
    }
}
