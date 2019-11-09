<?php

use Illuminate\Database\Seeder;
use App\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role admin
        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'A administrator user';
        $role_admin->save();

        // Role Choir moderator
        $role_choir_moderator = new Role();
        $role_choir_moderator->name = 'choir_moderator';
        $role_choir_moderator->description = 'A choir moderator user';
        $role_choir_moderator->permissions = json_encode([
            'list-songs' => true,
            'create-song' => true,
            'update-song' => true,
            'delete-song' => true,
        ]);
        $role_choir_moderator->save();

        // Role choir member
        $role_choir_member = new Role();
        $role_choir_member->name = 'choir_member';
        $role_choir_member->description = 'A choir member user';
        $role_choir_member->permissions = json_encode([
            'list-songs' => true,
        ]);
        $role_choir_member->save();

        // Role editor 
        $role_editor = new Role();
        $role_editor->name = 'editor';
        $role_editor->description = 'A editor user';
        $role_editor->permissions = json_encode([
            'create-article' => true,
            'update-article' => true,
            'delete-article' => true,
            'list-drafts' => true,
            'create-message' => true,
            'update-message' => true,
            'delete-message' => true,
            'create-page' => true,
            'update-page' => true,
        ]);
        $role_editor->save();
        
        // Role writer 
        $role_writer = new Role();
        $role_writer->name = 'writer';
        $role_writer->description = 'A writer user';
        $role_writer->permissions = json_encode([
            'create-article' => true,
            'create-message' => true,
            'list-drafts' => true,
        ]);
        $role_writer->save();

        // Role Member 
        $role_member = new Role();
        $role_member->name = 'member';
        $role_member->description = 'A member user';
        $role_member->save();

        // Role speaker
        $role_speaker = new Role();
        $role_speaker->name = 'speaker';
        $role_speaker->description = 'A speaker user';
        $role_speaker->save();

    }
}
