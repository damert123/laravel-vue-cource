<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
         'admin',
         'create_only',
         'read_only',
         'update_only',
         'delete_only',
         'moderator_posts',
         'moderator_comments',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['title' => $role]);
        }

        $userAdmin = User::where('email', 'admin@admin.com')->first();
        $userReader = User::where('email', 'reader@reader.com')->first();
        $userDeleter = User::where('email', 'deleter@deleter.com')->first();
        $userUpdater = User::where('email', 'updater@updater.com')->first();
        $userCreater = User::where('email', 'creater@creater.com')->first();
        $userModeratorPosts = User::where('email', 'moderator_posts@moderator.com')->first();
        $userModeratorComments = User::where('email', 'moderator_comments@moderator.com')->first();


        $roleAdmin = Role::where('title', 'admin')->first();
        $roleReader = Role::where('title', 'read_only')->first();
        $roleUpdater = Role::where('title', 'update_only')->first();
        $roleDeleter = Role::where('title', 'delete_only')->first();
        $roleCreater = Role::where('title', 'create_only')->first();
        $roleModeratorPosts = Role::where('title', 'moderator_posts')->first();
        $roleModeratorComments = Role::where('title', 'moderator_comments')->first();

        $userAdmin->roles()->sync([$roleAdmin->id]);
        $userReader->roles()->sync([$roleReader->id]);
        $userDeleter->roles()->sync([$roleDeleter->id]);
        $userUpdater->roles()->sync([$roleUpdater->id]);
        $userCreater->roles()->sync([$roleCreater->id]);
        $userModeratorPosts->roles()->sync([$roleModeratorPosts->id]);
        $userModeratorComments->roles()->sync([$roleModeratorComments->id]);
    }
}
