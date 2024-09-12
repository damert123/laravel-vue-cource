<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function indexProfile(User $user)
    {

        $user->load('profile');


        return new ProfileResource($user);


    }
}
