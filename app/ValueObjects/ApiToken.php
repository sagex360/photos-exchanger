<?php


namespace App\ValueObjects;


use Illuminate\Support\Str;
use InvalidArgumentException;

final class ApiToken
{
    public const TOKEN_MAX_LENGTH = 80;
    public const TOKEN_MIN_LENGTH = 30;

    protected string $token;

    /**
     * ApiToken constructor.
     * @param string $token
     */
    protected function __construct(string $token)
    {
        $this->token = $token;


        $len = strlen($token);

        if ($len < self::TOKEN_MIN_LENGTH) {
            throw new InvalidArgumentException('Token must be at least ' . self::TOKEN_MIN_LENGTH);
        }

        if ($len > self::TOKEN_MAX_LENGTH) {
            throw new InvalidArgumentException('Token must be less than ' . self::TOKEN_MAX_LENGTH);
        }
    }

    public static function generate(): self
    {
        return new static(Str::orderedUuid());
    }

    public static function create(string $token): self
    {
        return new static($token);
    }

    public function token(): string
    {
        return $this->token;
    }
}
