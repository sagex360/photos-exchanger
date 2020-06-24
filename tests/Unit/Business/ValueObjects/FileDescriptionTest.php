<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\FileDescription;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class FileDescriptionTest extends TestCase
{
    public function testEmptyName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $fileDescription = FileDescription::create('', 'some description');
    }

    public function testEmptyDescription()
    {
        $this->expectException(\InvalidArgumentException::class);
        $fileDescription = FileDescription::create('not empty', '');
    }

    public function testTooLongName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $fileDescription = FileDescription::create(
            Str::random(FileDescription::MAX_PUBLIC_NAME + 1),
            'some description'
        );
    }

    public function testTooLongDescription()
    {
        $this->expectException(\InvalidArgumentException::class);

        $fileDescription = FileDescription::create(
            'some name',
            Str::random(FileDescription::MAX_DESCRIPTION + 1)
        );
    }

    public function testSuccessfulCreation()
    {
        $fileDescription = FileDescription::create('some name', 'some description');

        $this->assertSame('some name', $fileDescription->publicName());
        $this->assertSame('some description', $fileDescription->description());
    }
}
