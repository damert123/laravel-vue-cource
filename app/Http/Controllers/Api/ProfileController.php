<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\IndexRequest;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\ProfileResource;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        $profiles = Profile::filter($data)->get();

        return ProfileResource::collection($profiles)->resolve();
    }

    public function indexProfile(){


        $profileUser = ProfileResource::make(Profile::where('user_id', auth()->id())->firstOrfail())->resolve();




        return inertia('Profile/Main', [
            'profile' => $profileUser,

        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {



    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
