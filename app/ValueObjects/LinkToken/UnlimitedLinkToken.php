<?php


namespace App\ValueObjects\LinkToken;


final class UnlimitedLinkToken extends LinkToken
{
    public function type(): string
    {
        return 'unlimited';
    }

    public function typeReadable(): string
    {
        return trans('texts.entities.link-token.types.unlimited');
    }

    public function expired(): bool
    {
        return false;
    }
}
