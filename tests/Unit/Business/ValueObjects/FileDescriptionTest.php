<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\FileDescription;
use PHPUnit\Framework\TestCase;

class FileDescriptionTest extends TestCase
{
    public function testSuccessfulCreation()
    {
        $name = uniqid();
        $fileDescription = FileDescription::create($name, 'some description');

        $this->assertSame($name, $fileDescription->realName());
        $this->assertSame($fileDescription->description(), 'some description');
    }
}
