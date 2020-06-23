<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\DeletionDate\DeletionDateFactory;
use App\ValueObjects\DeletionDate\NotNullDeletionDate;
use App\ValueObjects\DeletionDate\NullDeletionDate;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class DeletionDateTest extends TestCase
{
    public function testCreateExpiredDeletionDate()
    {
        $deletionDate = new NotNullDeletionDate(Carbon::yesterday());
        $this->assertTrue($deletionDate->expired());
    }

    public function testCreateDeletionDateNow()
    {
        $deletionDate = new NotNullDeletionDate(Carbon::now());
        $this->assertTrue($deletionDate->expired());
    }

    public function testSuccessfulDeletionDate()
    {
        $deletionDate = new NotNullDeletionDate(Carbon::tomorrow());
        $this->assertFalse($deletionDate->expired());
    }

    public function testDateTimeFormatting()
    {
        $sourceDate = Carbon::tomorrow();
        $deletionDate = new NotNullDeletionDate($sourceDate);

        $this->assertEquals(
            $sourceDate->format('Y-m-d'),
            $deletionDate->format('Y-m-d')
        );
    }

    public function testNullDeletionDateFromFormat()
    {
        $deletionDate = DeletionDateFactory::fromFormat('Y-m-d', null);

        $this->assertInstanceOf(NullDeletionDate::class, $deletionDate);
    }

    public function testCreateDeletionDateFromEmptyString()
    {
        $deletionDate = DeletionDateFactory::fromFormat('Y-m-d', '');

        $this->assertInstanceOf(NullDeletionDate::class, $deletionDate);
    }

    public function testInvalidFormatOfDeletionDate()
    {
        $this->expectException(\Carbon\Exceptions\InvalidFormatException::class);

        DeletionDateFactory::fromFormat('Y-m-d', '2020/02/12');
    }

    public function testNullDeletionDate()
    {
        $nullDeletionDate = NullDeletionDate::instance();

        $this->assertSame(null, $nullDeletionDate->format('...'));
        $this->assertSame(false, $nullDeletionDate->expired());
    }
}
