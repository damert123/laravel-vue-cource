<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {

        $userPosts = PostResource::collection(Post::where('profile_id', auth()->user()->profile->id)->get())->resolve();

        return inertia('Main/Index', [
            'userPosts' => $userPosts
        ]);
    }
}
