<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\ApiToken;
use Illuminate\Support\Str;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ApiTokenTest extends TestCase
{
    public function testTooShortTokenLength(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $token = ApiToken::create(Str::random(ApiToken::TOKEN_MIN_LENGTH - 1));
    }

    public function testTokenWithMinLength(): void
    {
        $rawToken = Str::random(ApiToken::TOKEN_MIN_LENGTH);
        $token = ApiToken::create($rawToken);

        self::assertSame($rawToken, $token->token());
    }

    public function testTooLongTokenLength(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $token = ApiToken::create(Str::random(ApiToken::TOKEN_MAX_LENGTH + 1));
    }

    public function testTokenWithMaxLength(): void
    {
        $rawToken = Str::random(ApiToken::TOKEN_MAX_LENGTH);
        $token = ApiToken::create($rawToken);

        self::assertSame($rawToken, $token->token());
    }

    public function testAverageTokenLength(): void
    {
        $rawToken = 'oa34ADE99VmgwbiiBNx4L8JisLKvgTk8clstWtBQmLc6cVKNo2';

        $token = ApiToken::create($rawToken);

        self::assertSame($rawToken, $token->token());
    }

    public function testAutomaticCreation(): void
    {
        $apiToken = ApiToken::generate();

        self::assertIsString($apiToken->token());
    }
}
