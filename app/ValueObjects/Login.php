<?php


namespace App\ValueObjects;


use InvalidArgumentException;

final class Login
{
    /**
     * @var string
     */
    protected $email;

    private function __construct(string $login)
    {
        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email "' . $login . '" is not valid');
        }

        $this->email = $login;
    }

    public static function create(string $login)
    {
        return new static($login);
    }

    public function value(): string
    {
        return $this->email;
    }

    public function equals(Login $other): bool
    {
        return $this->email === $other->email;
    }

    public function __toString()
    {
        return $this->value();
    }
}
