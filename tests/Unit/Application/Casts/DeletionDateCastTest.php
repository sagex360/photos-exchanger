<?php

namespace Tests\Unit\Application\Casts;

use App\Models\File;
use App\ValueObjects\DeletionDate\NotNullDeletionDate;
use App\ValueObjects\DeletionDate\NullDeletionDate;
use App\ValueObjects\FileDescription;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class DeletionDateCastTest extends TestCase
{
    public function testExample()
    {
        $file = new File();
        $file->user_id = 1;
        $file->will_be_deleted_at = NullDeletionDate::instance();
        $file->description = FileDescription::create('some description');

        $this->assertInstanceOf(NullDeletionDate::class, $file->will_be_deleted_at);
        $file->will_be_deleted_at = new NotNullDeletionDate(Carbon::tomorrow());

        $this->assertInstanceOf(NotNullDeletionDate::class, $file->will_be_deleted_at);
    }
}