<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\CommentResource;
use App\Http\Resources\Post\PostLikeResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Profile;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();

    }


    public function show(Post $post)
    {

        return PostResource::make($post)->resolve();

    }

    public function showComments(Post $post)
    {

        $comments = $post->comments()->get();

        return CommentResource::collection($comments)->resolve();

    }

    public function storeComment(Post $post)
    {
        $post = $post->comments()->create([
            'profile_id' => 4,
            'title' =>  'Привет этот комент был создан!'
        ]);

        return CommentResource::make($post)->resolve();
    }

    public function destroyComment(Post $post)
    {
        $post = $post->comments()->where('profile_id', 4)->delete();

        return response([
            'message' => 'comment deleted'
        ], Response::HTTP_OK);
    }




    public function showLikes(Post $post)
    {
        $likes = $post->likes()->get();



        return PostLikeResource::collection($likes)->resolve();
    }




    public function store()
    {
        $data = [
            'title' => 'Привет это тест пост',
            'content' => 'Очень важный контент !!!',
            'published_at' => now(),
            'profile_id' => Profile::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'image_path' => fake()->imageUrl(),
            'status' => null,
            'views' => '666',

        ];

        $post = PostService::create($data);

        return PostResource::make($post);
    }


    public function update(Post $post)
    {
        $data = [
            'title' => 'my post'
        ];

        $post->update($data);

        return $post;

    }

    public function destroy(Post $post)
    {
        $id = 5;
        $post = Post::find($id);

        $post->delete();

        return response([
            'message' => 'post deleted'
        ], Response::HTTP_OK);

    }
}
