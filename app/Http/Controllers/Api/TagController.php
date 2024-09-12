<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Requests\Tag\UpdateRequest;
use App\Http\Resources\Post\CommentResource;
use App\Http\Resources\Post\TagResource;
use App\Models\Comment;
use App\Models\Tag;
use App\Services\CommentService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tag = Tag::all();

        return TagResource::collection($tag)->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();


        $tag = TagService::create($data);

        return  TagResource::make($tag)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return TagResource::make($tag)->resolve();

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Tag $tag)
    {
        $data = $request->validated();

        $tag = TagService::update($tag, $data);

        return  TagResource::make($tag)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        TagService::delete($tag);

        return response([
            'message' => 'Tag deleted successfully'
        ], Response::HTTP_OK);
    }
}
