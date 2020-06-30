<?php


namespace App\ValueObjects\LinkToken;


final class DisposableLinkToken extends LinkToken
{
    public function type(): string
    {
        return 'disposable';
    }

    public function expired(int $visitsCount): bool
    {
        return $visitsCount !== 0;
    }
}
