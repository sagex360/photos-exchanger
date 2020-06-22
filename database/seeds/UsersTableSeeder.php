<?php

use App\Models\Client;
use App\ValueObjects\Login;
use App\ValueObjects\Name;
use App\ValueObjects\Password as Password;
use Illuminate\Database\Seeder;

final class UsersTableSeeder extends Seeder
{
    const PASSWORD = 'password';

    public static function limit()
    {
        return 10;
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
            $client = new Client();

            $client->name = Name::create($faker->unique()->name);
            $client->email = Login::create($faker->unique()->email);
            $client->password = Password::create(self::PASSWORD);
            
            $client->save();
        }
    }
}
