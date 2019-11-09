<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SeriesTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(SongsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
    }
}
