<?php


namespace App\ValueObjects\LinkToken;


use App\Casts\LinkTokenCast;
use App\Models\FileLinkToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class LinkTokensFactory
{
    protected static function generateToken(): string
    {
        return Str::orderedUuid();
    }

    public static function create(FileLinkToken $model, string $type, string $value = null): LinkToken
    {
        switch ($type) {
            case 'disposable':
                return DisposableLinkToken::create($value ?? static::generateToken(), $model);

            case 'unlimited':
                return UnlimitedLinkToken::create($value ?? static::generateToken(), $model);

            default:
                throw new \InvalidArgumentException('Unexpected token type: ' . $type);
        }
    }
}
