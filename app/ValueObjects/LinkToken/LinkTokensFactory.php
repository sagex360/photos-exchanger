<?php


namespace App\ValueObjects\LinkToken;


use Illuminate\Support\Str;
use InvalidArgumentException;

final class LinkTokensFactory
{
    public static function supportedTypes(): array
    {
        return ['disposable', 'unlimited'];
    }

    private static function generateToken(): string
    {
        return Str::orderedUuid();
    }

    public static function create(string $type, string $value = null): LinkToken
    {
        switch ($type) {
            case 'disposable':
                return DisposableLinkToken::create($value ?? static::generateToken());

            case 'unlimited':
                return UnlimitedLinkToken::create($value ?? static::generateToken());

            default:
                throw new InvalidArgumentException('Unexpected token type: '.$type);
        }
    }
}
