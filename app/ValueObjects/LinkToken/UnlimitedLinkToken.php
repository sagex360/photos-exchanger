<?php


namespace App\ValueObjects\LinkToken;


final class UnlimitedLinkToken extends LinkToken
{
    public function type(): string
    {
        return 'unlimited';
    }

    public function expired(int $visitsCount): bool
    {
        return false;
    }
}
