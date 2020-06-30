<?php


namespace App\ValueObjects\LinkToken;


abstract class LinkToken
{
    const STATUS_NOT_USED = 'not-used';
    const STATUS_EXPIRED = 'expired';
    const STATUS_USED_N_TIMES = 'used-n-times';

    protected string $token;

    protected function __construct(string $token)
    {
        $this->token = $token;
    }

    public static function create(string $token)
    {
        return new static($token);
    }

    public function equals(self $other): bool
    {
        return ($other instanceof static)
            && $this->token === $other->token;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function status(int $visitsCount): string
    {
        if ($visitsCount === 0) {
            return self::STATUS_NOT_USED;
        }

        if ($this->expired($visitsCount)) {
            return self::STATUS_EXPIRED;
        }

        return self::STATUS_USED_N_TIMES;
    }

    public abstract function type(): string;

    public abstract function expired(int $visitsCount): bool;
}
