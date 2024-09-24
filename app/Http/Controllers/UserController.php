<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\User\ProfileResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function indexProfile(User $user)
    {

        $user->load('profile');

        return new ProfileResource($user);

    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $user = UserService::create($data);



        return response()->json([
            'message' => 'Пользователь успешно создан',
        ], 201);

    }
}
