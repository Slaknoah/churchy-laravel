<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Get Roles
        $role_admin = Role::where('name', 'admin')->first();
        $role_choir_moderator = Role::where('name', 'choir_moderator')->first();
        $role_choir_member = Role::where('name', 'choir_member')->first();
        $role_editor = Role::where('name', 'editor')->first();
        $role_writer = Role::where('name', 'writer')->first();
        $role_member = Role::where('name', 'member')->first();
        $role_speaker = Role::where('name', 'speaker')->first();

        /* Create Admin User */
        $admin = factory(App\User::class)->create([
            'email' => 'admin@email.com',
        ]);
        $admin->roles()->attach($role_admin);
        
        /* Create Choir moderator User */
        $choir_moderator = factory(App\User::class)->create([
            'email' => 'choir_moderator@email.com',
        ]);
        $choir_moderator->roles()->attach($role_choir_moderator);


        /* Create Choir member User */
        $choir_member = factory(App\User::class)->create([
            'email' => 'choir_member@email.com',
        ]);
        $choir_member->roles()->attach($role_choir_member);

        /* Create Editor User */
        $editor = factory(App\User::class)->create([
            'email' => 'editor@email.com',
        ]);
        $editor->roles()->attach($role_editor);
        
        /* Create Writer User */
        $writer = factory(App\User::class)->create([
            'email' => 'writer@email.com',
        ]);
        $writer->roles()->attach($role_writer);

        /* Create Member User */
        $member = factory(App\User::class)->create([
            'email' => 'member@email.com',
        ]);
        $member->roles()->attach($role_member);
        
        
        /* Create Speaker Users */
        for ($i=0; $i < 5; $i++) { 
            $speaker = factory(App\User::class)->create([
                'email' => 'speaker_' . ($i+1) . '@email.com'
            ]);

            $speaker->roles()->attach($role_speaker);
            $speaker->roles()->attach($role_member);
        }

    }
}
