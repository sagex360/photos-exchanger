<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\Login;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function test_empty_login(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $login = Login::create('');
    }

    public function test_invalid_login(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $login = Login::create('not_valid_email@');
    }

    public function test_successful_creation(): void
    {
        $login = Login::create('admin@gmail.com');

        self::assertSame('admin@gmail.com', $login->value());
        self::assertSame('admin@gmail.com', "$login");
    }

    public function test_login_equals(): void
    {
        $login1 = Login::create('admin@gmail.com');
        $login2 = Login::create('admin@gmail.com');

        self::assertTrue($login1->equals($login2));
    }

    public function test_login_not_equals(): void
    {
        $login1 = Login::create('admin1@gmail.com');
        $login2 = Login::create('admin2@gmail.com');

        self::assertFalse($login1->equals($login2));
    }
}
