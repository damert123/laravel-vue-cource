<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\PostException;
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

//    protected $postService;
//
//    public function __construct(PostService $postService)
//    {
//        $this->postService = $postService;
//    }

    public function testProcessPost()
    {
        try {
            PostService::processPost();
            return response()->json(['message' => 'Post processing complete'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

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




    public function process()
    {
        $title = 'Animi labore qui assumenda.';

        $post = Post::firstOrCreate([
            'title' => $title
        ],[
            'profile_id' => 1,
            'category_id' => 1,
        ]);


        PostException::checkIfPostExists($post);


    }
}
