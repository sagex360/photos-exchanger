<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\Login;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testEmptyLogin()
    {
        $this->expectException(\InvalidArgumentException::class);
        $login = Login::create('');
    }

    public function testInvalidLogin()
    {
        $this->expectException(\InvalidArgumentException::class);

        $login = Login::create('not_valid_email@');
    }

    public function testSuccessfulCreation()
    {
        $login = Login::create('admin@gmail.com');

        $this->assertSame('admin@gmail.com', $login->value());
        $this->assertSame('admin@gmail.com', "$login");
    }

    public function testLoginEquals()
    {
        $login1 = Login::create('admin@gmail.com');
        $login2 = Login::create('admin@gmail.com');

        $this->assertTrue($login1->equals($login2));
    }

    public function testLoginNotEquals()
    {
        $login1 = Login::create('admin1@gmail.com');
        $login2 = Login::create('admin2@gmail.com');

        $this->assertFalse($login1->equals($login2));
    }
}
