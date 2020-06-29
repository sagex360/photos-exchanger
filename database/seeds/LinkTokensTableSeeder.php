<?php

use App\Models\FileLinkToken;
use App\ValueObjects\LinkToken\LinkTokensFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

final class LinkTokensTableSeeder extends Seeder
{
    public static function limit()
    {
        return 200;
    }

    protected function tokenTypes()
    {
        return [
            'disposable',
            'unlimited'
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();


        for ($i = 0; $i < self::limit(); ++$i) {
            $entity = new FileLinkToken();

            $entity->token = LinkTokensFactory::create(Arr::random($this->tokenTypes()));
            $entity->file_id = $faker->numberBetween(1, FilesTableSeeder::limit());

            $entity->save();
        }
    }
}
