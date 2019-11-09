<?php

use Illuminate\Database\Seeder;
use App\Page;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Page::class, 3)->create(); 
        
        // Create about page
        $about_page = factory(App\Page::class)-> create([
            'title' => 'About',
            'slug' => 'about',
            'template' => 'about'
        ]);

        // Contact page
        $contact_page = factory(App\Page::class)-> create([
            'title' => 'Contact',
            'slug' => 'contact',
            'template' => 'contact'
        ]);

    }
}
