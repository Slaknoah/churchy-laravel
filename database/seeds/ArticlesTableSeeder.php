<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Article::class, 3)->create([
            'series_id' => 1,
            'author_id' => 1, // Admin user
        ]);

        factory(App\Article::class, 3)->create([
            'series_id' => 1,
            'author_id' => 1, // Admin user
            'published' => 1,
        ]);
        factory(App\Article::class, 3)->create([
            'series_id' => 1,
            'author_id' => 2, // Manager user
            'published' => 1,
        ]);

        factory(App\Article::class, 3)->create([
            'series_id' => 1,
            'author_id' => 2, // Manager user
            'published' => 1,
        ]);

        factory(App\Article::class, 5)->create([
            'series_id' => 2,
            'author_id' => 4, // Editor user
        ]);
    }
}