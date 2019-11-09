<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Message::class, 3)->create([
            'series_id' => 1,
            'author_id' => 1, // Admin user
            'speaker_id' => 6 // Speaker user
        ]);
        factory(App\Message::class, 3)->create([
            'series_id' => 2,
            'author_id' => 4, // Editor user
            'speaker_id' => 7 // Speaker user
        ]);
        factory(App\Message::class, 3)->create([
            'series_id' => 3,
            'author_id' => 4, // Editor user
            'speaker_id' => 8
         ]);
    }
}
