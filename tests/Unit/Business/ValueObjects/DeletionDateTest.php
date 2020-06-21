<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\DeletionDate\IlluminateCarbonDeletionDateFactory;
use App\ValueObjects\DeletionDate\NullDeletionDate;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class DeletionDateTest extends TestCase
{
    public function testCreateExpiredDeletionDate()
    {
        $factory = new IlluminateCarbonDeletionDateFactory();

        $deletionDate = $factory->at(Carbon::yesterday());
        $this->assertTrue($deletionDate->expired());
    }

    public function testCreateDeletionDateNow()
    {
        $factory = new IlluminateCarbonDeletionDateFactory();

        $deletionDate = $factory->at(Carbon::now());
        $this->assertTrue($deletionDate->expired());
    }

    public function testSuccessfulDeletionDate()
    {
        $factory = new IlluminateCarbonDeletionDateFactory();

        $deletionDate = $factory->at(Carbon::tomorrow());
        $this->assertFalse($deletionDate->expired());
    }

    public function testToDateTimeStringConversion()
    {
        $factory = new IlluminateCarbonDeletionDateFactory();

        $sourceDate = Carbon::tomorrow();
        $deletionDate = $factory->at($sourceDate);
        $this->assertEquals(
            $sourceDate->toDateTimeString(),
            $deletionDate->toDateTimeString()
        );
    }

    public function testNullDeletionDateFromFormat()
    {
        $factory = new IlluminateCarbonDeletionDateFactory();

        $deletionDate = $factory->fromFormat('Y-m-d', null);
        $this->assertInstanceOf(NullDeletionDate::class, $deletionDate);
    }

    public function testCreateDeletionDateFromEmptyString()
    {
        $factory = new IlluminateCarbonDeletionDateFactory();

        $deletionDate = $factory->fromFormat('Y-m-d', '');
        $this->assertInstanceOf(NullDeletionDate::class, $deletionDate);
    }

    public function testInvalidFormatOfDeletionDate()
    {
        $factory = new IlluminateCarbonDeletionDateFactory();

        $this->expectException(\Carbon\Exceptions\InvalidFormatException::class);
        $factory->fromFormat('Y-m-d', '2020/02/12');
    }

    public function testNullDeletionDate()
    {
        $nullDeletionDate = NullDeletionDate::instance();

        $this->assertSame('', $nullDeletionDate->toDateTimeString());
        $this->assertSame(false, $nullDeletionDate->expired());
    }
}
