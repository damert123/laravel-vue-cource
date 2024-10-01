<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Http\Requests\Api\Post\IndexRequest;
use App\Http\Resources\Post\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(IndexRequest $request)
    {
        $data = $request->validationData();
//        $posts = Post::with('profile.user')->latest()->get();

        $posts = PostResource::collection(Post::filter($data)->latest()->paginate($data['per_page'], ['*'], 'page', $data['page'] ));

        if ($request->wantsJson()){
            return $posts;
        }


//        $posts = PostResource::collection($posts)->resolve();

        return inertia('Admin/Post/Index', compact('posts'));
    }

    public function store(StoreRequest $request)
    {

        $data = $request->validationData();
        $post = PostService::create($data);
//        return PostResource::make($post)->resolve();
        return response()->json([
            'message' => 'Пост успешно создан!',
            'post' => new PostResource($post)
        ], 201);
    }


    public function commentList(Post $post)
    {
        $comments = $post->comments()->latest()->get();

        return CommentResource::collection($comments);
    }

    public function destroy(Post $post)
    {
        PostService::delete($post);

        return response()->json([
            'message' => 'Пост успешно удален'
        ]);
    }
}
