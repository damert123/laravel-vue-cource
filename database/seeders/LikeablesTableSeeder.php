<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = Profile::all();


        $posts = Post::all();
        $comments = Comment::all();

//        ЛАЙКИ ДЛЯ ПОСТОВ
        foreach ($posts as $post) {
            foreach ($profiles->random(rand(1, 5)) as $profile) {
                $post->likeable()->attach($profile->id);
            }
        }

//        ЛАЙКИ ДЛЯ КОММЕНТОВ

        foreach ($comments as $comment) {
            foreach ($profiles->random(rand(1, 5)) as $profile) {
                $comment->likeable()->attach($profile->id);
            }
        }
    }
}
