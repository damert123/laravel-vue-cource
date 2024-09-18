<?php

namespace App\Console\Commands;

use App\Events\UserRegistered;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Observer;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Profile;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Print_;

class GoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test homework';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $post = Post::factory()->create();
//        $post = Post::first();
//        Log::channel('crud')->info("Post created: ID {$post->id}");

//        Log::channel('posts')->info('Post created for id:{id}', ['id' => $post->id]);

//        $user = User::find(3);
//
//        dd($user->hasRole('reader'));

//        $post = Post::first();
//
//        $comment = Comment::first();
//
//        $tag = Tag::first();
//
//        $profile = Profile::first();



//        $post->update([
//            'title' => 'Change !'
//        ]);
//
//        $comment->update([
//            'title' => 'Another change !'
//        ]);
//
//        $tag->update([
//            'name' => 'TAG UPDATED !'
//        ]);
//
//        $profile->update([
//            'city' => 'City profile UPDATED !'
//        ]);



//        $model = Profile::find(1);
//
//        $check = get_class($model);
//
//        dd($check);



    }
}
