<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\PostFilter;
use App\Http\Requests\Api\Post\IndexRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Profile;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        $posts = Post::filter($data)->get();

        return PostResource::collection($posts)->resolve();
    }

    public function show(Post $post)
    {

        return PostResource::make($post)->resolve();
    }


    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $post = PostService::create($data);

        return PostResource::make($post);
    }

    public function update(Post $post, UpdateRequest $request)
    {
        $data = $request->validated();

        $post = PostService::update($post, $data);
        return PostResource::make($post);
    }

    public function destroy(Post $post)
    {
        PostService::delete($post);

        return response([
            'message' => 'Post deleted successfully'
        ], Response::HTTP_OK);

    }
}
