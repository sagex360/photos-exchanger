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
    public function test_create_expired_deletion_date(): void
    {
        $deletionDate = new NotNullDeletionDate(Carbon::yesterday());
        self::assertTrue($deletionDate->expired());
    }

    public function test_create_deletion_date_now(): void
    {
        $deletionDate = new NotNullDeletionDate(Carbon::now());
        self::assertTrue($deletionDate->expired());
    }

    public function test_successful_deletion_date(): void
    {
        $deletionDate = new NotNullDeletionDate(Carbon::tomorrow());
        self::assertFalse($deletionDate->expired());
    }

    public function test_date_time_formatting(): void
    {
        $sourceDate = Carbon::tomorrow();
        $deletionDate = new NotNullDeletionDate($sourceDate);

        self::assertEquals(
            $sourceDate->format('Y-m-d'),
            $deletionDate->format('Y-m-d')
        );
    }

    public function test_null_deletion_date_from_format(): void
    {
        $deletionDate = DeletionDateFactory::fromFormat('Y-m-d', null);

        self::assertInstanceOf(NullDeletionDate::class, $deletionDate);
    }

    public function test_create_deletion_date_from_empty_string(): void
    {
        $deletionDate = DeletionDateFactory::fromFormat('Y-m-d', '');

        self::assertInstanceOf(NullDeletionDate::class, $deletionDate);
    }

    public function test_invalid_format_of_deletion_date(): void
    {
        $this->expectException(InvalidFormatException::class);

        DeletionDateFactory::fromFormat('Y-m-d', '2020/02/12');
    }

    public function test_null_deletion_date(): void
    {
        $nullDeletionDate = NullDeletionDate::instance();

        self::assertNull($nullDeletionDate->format('...'));
        self::assertFalse($nullDeletionDate->expired());
    }
}
