<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostService
{



    public static function create(array $data): Post
    {

        unset($data['image']);

        return Post::create($data);
    }

    public static function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post;
    }

    public static function delete(Post $post): void
    {
        if ($post->image_path){
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

    }

    public static function processPost()
    {
        try {
            $post = Post::updateOrCreate(
                ['title' => 'Some title fsdfsdf'],
                ['content' => 'Some content',
                    'profile_id' => 1,
                    'category_id' => 1],
            );
            throw new CustomException($post, 'updateOrCreate', 'Post operation complete');
        } catch (CustomException $e) {
            $e->report();
        }

        try {
            $post = Post::firstOrCreate(
                ['title' => 'Another title'],
                ['content' => 'Another content',
                    'profile_id' => 1,
                    'category_id' => 1],

            );
            throw new CustomException($post, 'firstOrCreate', 'Post operation complete');
        } catch (CustomException $e) {
            $e->report();
        }
    }

}
