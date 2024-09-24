<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\CategoryResource;
use App\Http\Resources\Post\PostSelectResource;
use App\Http\Resources\Video\VideoSelectResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $categories = CategoryResource::collection(Category::all())->resolve();
        $posts = PostSelectResource::collection(Post::all())->resolve();
        $videos = VideoSelectResource::collection(Video::all())->resolve();
        return inertia('Admin/Index', compact('categories', 'posts', 'videos'));
    }
}
