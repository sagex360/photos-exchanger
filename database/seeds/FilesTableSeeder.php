<?php

use App\Models\File;
use App\ValueObjects\DeletionDate\NotNullDeletionDate;
use App\ValueObjects\DeletionDate\NullDeletionDate;
use App\ValueObjects\FileDescription;
use App\ValueObjects\FileLocation\FileLocation;
use App\ValueObjects\FileLocation\FilesFolderLocator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class FilesTableSeeder extends Seeder
{
    protected FilesFolderLocator $folderLocator;

    public function __construct(FilesFolderLocator $folderLocator)
    {
        $this->folderLocator = $folderLocator;
    }

    public static function limit()
    {
        return 30;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new \App\Lib\Faker\Providers\PicsumImage($faker));

        $path = config('filesystems.disks.public.root') . '/' . $this->folderLocator->locate('public');

        for ($i = 0; $i < self::limit(); ++$i) {
            $file = new File();

            $file->description = FileDescription::create(
                $faker->text(70),
                $faker->text(300)
            );

            $realFileName = $faker->image($path, 1280, 720, null, false);
            $file->location = FileLocation::in('public', $realFileName);

            $file->will_be_deleted_at = ($faker->boolean(60)) ?
                new NotNullDeletionDate(Carbon::instance($faker->dateTimeThisYear('+2 years')))
                : NullDeletionDate::instance();

            $file->user_id = $faker->numberBetween(1, UsersTableSeeder::limit());

            $file->save();
        }
    }
}
