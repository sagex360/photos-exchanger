<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PasswordTest extends \Tests\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testEmptyPassword()
    {
        $this->expectException(InvalidArgumentException::class);
        $password = Password::create('');
    }

    public function testTooShortPassword()
    {
        $this->expectException(InvalidArgumentException::class);
        $password = Password::create(Str::random(Password::MIN_LENGTH - 1));
    }

    public function testSuccessfulCreation()
    {
        $password = Password::create('12345678');

        $this->assertSame($password->hash(), "$password");
    }

    public function testCreationFromHash()
    {
        $hashedPassword = Hash::make('my_password');

        $password = Password::fromHash($hashedPassword);

        $this->assertEquals($password->hash(), $hashedPassword);
    }
}
