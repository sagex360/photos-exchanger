<?php


namespace App\ValueObjects\LinkToken;


use App\Models\FileLinkToken;

abstract class LinkToken
{
    protected string $token;

    protected FileLinkToken $parent;

    protected function __construct(string $token, FileLinkToken $parent)
    {
        $this->token = $token;
        $this->parent = $parent;
    }

    public static function create(string $token, FileLinkToken $parent)
    {
        return new static($token, $parent);
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

    public function link(): string
    {
        return route('guest.view.files.show', $this->token());
    }

    public function visits(): int
    {
        return $this->parent->visits_count;
    }

    public function statusReadable(): string
    {
        $visits = $this->visits();

        if ($visits === 0) {
            return trans('texts.entities.link-token.status.not-used');
        }

        return sprintf(
            trans('texts.entities.link-token.status.used-n-times'),
            $visits
        );
    }

    public abstract function type(): string;

    public abstract function typeReadable(): string;

    public abstract function expired(): bool;
}
