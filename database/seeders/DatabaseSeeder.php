<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{




    public function run(): void
    {
        $userAdmin =  User::firstOrCreate([
            'email' => 'admin@admin.com',

        ], [
            'name' => 'Admin',
            'password' => Hash::make(123123123),
        ]);

        $userReader =  User::firstOrCreate([
            'email' => 'reader@reader.com',

        ], [
            'name' => 'Reader',
            'password' => Hash::make(123123123),
        ]);


        $userDeleter =  User::firstOrCreate([
            'email' => 'deleter@deleter.com',

        ], [
            'name' => 'Deleter',
            'password' => Hash::make(123123123),
        ]);

        $userUpdater =  User::firstOrCreate([
            'email' => 'updater@updater.com',

        ], [
            'name' => 'Updater',
            'password' => Hash::make(123123123),
        ]);

        $userCreater =  User::firstOrCreate([
            'email' => 'creater@creater.com',

        ], [
            'name' => 'Creater',
            'password' => Hash::make(123123123),
        ]);

        $userModeratorPosts =  User::firstOrCreate([
            'email' => 'moderator_posts@moderator.com',

        ], [
            'name' => 'Moderator Posts',
            'password' => Hash::make(123123123),
        ]);

        $userModeratorComments =  User::firstOrCreate([
            'email' => 'moderator_comments@moderator.com',

        ], [
            'name' => 'Moderator Comments',
            'password' => Hash::make(123123123),
        ]);





        $this->call([
            RoleSeeder::class,
            PermissionSedder::class,
            CategorySeeder::class,
            TagSeeder::class,
            UserSeeder::class,
            VideoSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            LikeablesTableSeeder::class
        ]);

    }
}
