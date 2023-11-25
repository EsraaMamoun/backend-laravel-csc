<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public function index()
    {
        $users = User::where('account_type', 'user')->orderBy('id', 'desc')->paginate(10);

        return UserResource::collection($users);
    }

    public function findAll() {
        $subjects = Subject::all();
        return response()->json(['data' => $subjects]);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);

        return new UserResource($user);
    }

    public function findById($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response("", 204);
    }
}
