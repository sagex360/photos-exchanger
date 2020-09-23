<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\ApiToken;
use Illuminate\Support\Str;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ApiTokenTest extends TestCase
{
    public function test_too_short_token_length(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $token = ApiToken::create(Str::random(ApiToken::TOKEN_MIN_LENGTH - 1));
    }

    public function test_token_with_min_length(): void
    {
        $rawToken = Str::random(ApiToken::TOKEN_MIN_LENGTH);
        $token = ApiToken::create($rawToken);

        self::assertSame($rawToken, $token->token());
    }

    public function test_too_long_token_length(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $token = ApiToken::create(Str::random(ApiToken::TOKEN_MAX_LENGTH + 1));
    }

    public function test_token_with_max_length(): void
    {
        $rawToken = Str::random(ApiToken::TOKEN_MAX_LENGTH);
        $token = ApiToken::create($rawToken);

        self::assertSame($rawToken, $token->token());
    }

    public function test_average_token_length(): void
    {
        $rawToken = 'oa34ADE99VmgwbiiBNx4L8JisLKvgTk8clstWtBQmLc6cVKNo2';

        $token = ApiToken::create($rawToken);

        self::assertSame($rawToken, $token->token());
    }

    public function test_automatic_creation(): void
    {
        $apiToken = ApiToken::generate();

        self::assertIsString($apiToken->token());
    }
}
