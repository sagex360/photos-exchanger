<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\Login;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testEmptyLogin(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $login = Login::create('');
    }

    public function testInvalidLogin(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $login = Login::create('not_valid_email@');
    }

    public function testSuccessfulCreation(): void
    {
        $login = Login::create('admin@gmail.com');

        self::assertSame('admin@gmail.com', $login->value());
        self::assertSame('admin@gmail.com', "$login");
    }

    public function testLoginEquals(): void
    {
        $login1 = Login::create('admin@gmail.com');
        $login2 = Login::create('admin@gmail.com');

        self::assertTrue($login1->equals($login2));
    }

    public function testLoginNotEquals(): void
    {
        $login1 = Login::create('admin1@gmail.com');
        $login2 = Login::create('admin2@gmail.com');

        self::assertFalse($login1->equals($login2));
    }
}
