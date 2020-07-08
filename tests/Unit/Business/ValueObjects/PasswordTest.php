<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    public function testEmptyPassword(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $password = Password::create('');
    }

    public function testTooShortPassword(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $password = Password::create(Str::random(Password::MIN_LENGTH - 1));
    }

    public function testSuccessfulCreation(): void
    {
        $password = Password::create('12345678');

        self::assertSame($password->hash(), (string)$password);
    }

    public function testCreationFromHash(): void
    {
        $hashedPassword = Hash::make('my_password');

        $password = Password::fromHash($hashedPassword);

        self::assertEquals($password->hash(), $hashedPassword);
    }
}
