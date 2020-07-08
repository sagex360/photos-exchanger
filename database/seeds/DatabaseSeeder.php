<?php

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(FilesTableSeeder::class);
        $this->call(LinkTokensTableSeeder::class);
        $this->call(LinkVisitsTableSeeder::class);
    }
}
