<?php


namespace App\Services\Auth;


use App\Models\Client;
use Illuminate\Contracts\Auth\Authenticatable;
use InvalidArgumentException;

final class GuardResolver
{
    public const CATEGORY_DEFAULT = self::CATEGORY_HTTP;
    public const CATEGORY_HTTP = 'http';

    public function resolveGuard(Authenticatable $user, string $category = self::CATEGORY_DEFAULT): string
    {
        if ($user instanceof Client) {
            if ($category === self::CATEGORY_HTTP) {
                return 'web';
            }

            throw new InvalidArgumentException("Category '$category' not found.");
        }

        throw new InvalidArgumentException('Could not resolve guard for ' . get_class($user));
    }
}
