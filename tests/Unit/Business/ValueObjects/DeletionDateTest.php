<?php

namespace Tests\Unit\Business\ValueObjects;

use App\ValueObjects\DeletionDate\DeletionDateFactory;
use App\ValueObjects\DeletionDate\NotNullDeletionDate;
use App\ValueObjects\DeletionDate\NullDeletionDate;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class DeletionDateTest extends TestCase
{
    public function testCreateExpiredDeletionDate(): void
    {
        $deletionDate = new NotNullDeletionDate(Carbon::yesterday());
        self::assertTrue($deletionDate->expired());
    }

    public function testCreateDeletionDateNow(): void
    {
        $deletionDate = new NotNullDeletionDate(Carbon::now());
        self::assertTrue($deletionDate->expired());
    }

    public function testSuccessfulDeletionDate(): void
    {
        $deletionDate = new NotNullDeletionDate(Carbon::tomorrow());
        self::assertFalse($deletionDate->expired());
    }

    public function testDateTimeFormatting(): void
    {
        $sourceDate = Carbon::tomorrow();
        $deletionDate = new NotNullDeletionDate($sourceDate);

        self::assertEquals(
            $sourceDate->format('Y-m-d'),
            $deletionDate->format('Y-m-d')
        );
    }

    public function testNullDeletionDateFromFormat(): void
    {
        $deletionDate = DeletionDateFactory::fromFormat('Y-m-d', null);

        self::assertInstanceOf(NullDeletionDate::class, $deletionDate);
    }

    public function testCreateDeletionDateFromEmptyString(): void
    {
        $deletionDate = DeletionDateFactory::fromFormat('Y-m-d', '');

        self::assertInstanceOf(NullDeletionDate::class, $deletionDate);
    }

    public function testInvalidFormatOfDeletionDate(): void
    {
        $this->expectException(InvalidFormatException::class);

        DeletionDateFactory::fromFormat('Y-m-d', '2020/02/12');
    }

    public function testNullDeletionDate(): void
    {
        $nullDeletionDate = NullDeletionDate::instance();

        self::assertNull($nullDeletionDate->format('...'));
        self::assertFalse($nullDeletionDate->expired());
    }
}
