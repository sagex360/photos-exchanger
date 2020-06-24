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

    public function testShortenLongDescription()
    {
        $longString = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium ad alias atque autem dolore esse, excepturi fuga fugiat ipsa iusto laudantium, magni necessitatibus nesciunt nihil nulla numquam pariatur perspiciatis possimus, quas qui quo sed sunt velit veniam. Alias consectetur cumque debitis dignissimos, error impedit ipsam minima natus nemo nesciunt non, quis saepe similique ullam vel! Consequatur debitis eveniet expedita, id iste nihil quaerat ratione vero. Architecto, blanditiis commodi cupiditate ducimus eius harum ipsa neque numquam, optio praesentium quas totam vero voluptate. Eius, id tempora. Esse fuga inventore, ipsa, labore magni omnis provident quibusdam quo repellendus, sapiente sequi suscipit voluptas!';

        $fileDescription = FileDescription::create('some name', $longString);

        $this->assertSame(
            Str::limit($fileDescription->description(),
                FileDescription::SHORT_DESCRIPTION_LIMIT,
                '...'),
            $fileDescription->shortDescription()
        );
    }

    public function testShortenShortDescription()
    {
        $shortString = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet, quisquam.';

        $fileDescription = FileDescription::create('some name', $shortString);
        $this->assertSame(
            Str::limit($fileDescription->description(),
                FileDescription::SHORT_DESCRIPTION_LIMIT),
            $fileDescription->shortDescription()
        );
    }
}
