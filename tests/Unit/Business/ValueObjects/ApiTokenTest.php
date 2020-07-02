<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\ApiToken;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

final class ApiTokenTest extends TestCase
{
    public function testTooShortTokenLength()
    {
        $this->expectException(\InvalidArgumentException::class);

        $token = ApiToken::create(Str::random(ApiToken::TOKEN_MIN_LENGTH - 1));
    }

    public function testTokenWithMinLength()
    {
        $rawToken = Str::random(ApiToken::TOKEN_MIN_LENGTH);
        $token = ApiToken::create($rawToken);

        $this->assertSame($rawToken, $token->token());
    }

    public function testTooLongTokenLength()
    {
        $this->expectException(\InvalidArgumentException::class);

        $token = ApiToken::create(Str::random(ApiToken::TOKEN_MAX_LENGTH + 1));
    }

    public function testTokenWithMaxLength()
    {
        $rawToken = Str::random(ApiToken::TOKEN_MAX_LENGTH);
        $token = ApiToken::create($rawToken);

        $this->assertSame($rawToken, $token->token());
    }

    public function testAverageTokenLength()
    {
        $rawToken = 'oa34ADE99VmgwbiiBNx4L8JisLKvgTk8clstWtBQmLc6cVKNo2';

        $token = ApiToken::create($rawToken);

        $this->assertSame($rawToken, $token->token());
    }

    public function testAutomaticCreation()
    {
        $apiToken = ApiToken::generate();

        $this->assertIsString($apiToken->token());
    }
}
