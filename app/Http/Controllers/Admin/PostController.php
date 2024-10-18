<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Http\Requests\Api\Post\IndexRequest;
use App\Http\Requests\Post\StoreCommentRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\Post\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(IndexRequest $request)
    {
        $data = $request->validationData();

//        $posts = Post::with('profile.user')->latest()->get();

        $posts = PostResource::collection(Post::filter($data)->latest()->paginate($data['per_page'], ['*'], 'page', $data['page'] )->withQueryString());

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

    public function update(Post $post, UpdateRequest $request)
    {
        $data = $request->validationData();

        $post = PostService::update($post, $data);

        return response()->json([
            'selectedPost' => new PostResource($post),
            'message' => 'Пост редактирован'
        ]);

    }

    public function commentList(Post $post)
    {
        $comments = $post->comments()->parent()->with('replies')->take(3)->get();

        return CommentResource::collection($comments)->resolve();
//        return response()->json($comments);
    }

    public function storeComment(Post $post, StoreCommentRequest $request)
    {
        $data = $request->validationData();
        $comment = $post->comments()->create($data);
        return CommentResource::make($comment)->resolve();
    }

    public function destroyComment(Post $post, Comment $comment)
    {

        if ($comment->commentable_id === $post->id){
            CommentService::delete($comment);
            return response()->json(['success' => 'Комменатрий удален']);
        }else{
            return response()->json(['message' => 'Комменатрий не принадлежит данному посту']);
        }
    }

    public function destroy(Post $post)
    {
        PostService::delete($post);

        return response()->json([
            'message' => 'Пост успешно удален'
        ]);
    }
}
