<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\FileDescription;
use PHPUnit\Framework\TestCase;

class FileDescriptionTest extends TestCase
{
    public function testSuccessfulCreation()
    {
        $fileDescription = FileDescription::create('some description');

        $this->assertSame('some description', $fileDescription->description());
    }
}
