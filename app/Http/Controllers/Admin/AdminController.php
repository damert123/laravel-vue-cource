<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\CategoryResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\PostSelectResource;
use App\Http\Resources\User\RoleResource;
use App\Http\Resources\Video\VideoSelectResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Role;
use App\Models\Video;

class AdminController extends Controller
{
    public function index()
    {
        $categories = CategoryResource::collection(Category::all())->resolve();
        $posts = PostResource::collection(Post::latest()->paginate(3));
        $videos = VideoSelectResource::collection(Video::all())->resolve();
        $roles = RoleResource::collection(Role::all())->resolve();
        return inertia('Admin/Index', compact('categories', 'posts', 'videos', 'roles'));
    }
}
