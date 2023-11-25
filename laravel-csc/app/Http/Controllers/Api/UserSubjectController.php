<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserSubjectRequest;
use App\Http\Requests\CreateUserSubjectRequest;
use App\Http\Resources\UserSubjectResource;
use App\Models\UserSubject;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class UserSubjectController extends Controller
{
    public function index()
    {
        return UserSubjectResource::collection(UserSubject::query()->orderBy('id', 'desc')->paginate(10));
    }

    public function show(UserSubject $userSubject)
    {
        return new UserSubjectResource($userSubject);
    }


    public function update(UpdateUserSubjectRequest $request, UserSubject $userSubject)
    {
        $data = $request->validated();

        $userSubject->update($data);

        return new UserSubjectResource($userSubject);
    }

    public function store(CreateUserSubjectRequest $request)
    {
        $data = $request->validated();

        $userSubject = UserSubject::create($data);

        return response()->json(['data' => $userSubject], Response::HTTP_CREATED);
    }

    public function findById($userSubjectId)
    {
        $userSubject = UserSubject::find($userSubjectId);

        if (!$userSubject) {
            return response()->json(['error' => 'UserSubject not found'], 404);
        }

        return new UserSubjectResource($userSubject);
    }

    public function updateUsingAccountSubjectIds(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'users_id' => 'required',
                'subjects_id' => 'required',
                'mark' => 'required',
            ]);

            $affectedRows = UserSubject::where([
                'subjects_id' => $validatedData['subjects_id'],
                'users_id' => $validatedData['users_id'],
            ])->update(['mark' => $validatedData['mark']]);

            return response()->json(['success' => true, 'affected_rows' => $affectedRows]);
        } catch (\Exception $e) {
            return response()->json(["error' => 'Internal Server Error: $e"], 500);
        }
    }

    public function userSubjectMarks($users_id)
    {
        try {
            $userSubjects = UserSubject::where('users_id', $users_id)
                ->with('subject')
                ->get();

            return response()->json(['data' => $userSubjects]);
        } catch (\Exception $e) {
            return response()->json(["error' => 'Internal Server Error: $e"], 500);
        }
    }

    public function getUsersWithoutSubject($subjectId) {
        try {
            $usersWithoutSubject = User::where('account_type', 'user')
            ->whereDoesntHave('userSubjects', function ($query) use ($subjectId) {
                $query->where('subjects_id', $subjectId);
            })->get();

            return response()->json(['data' => $usersWithoutSubject]);
        } catch (\Exception $e) {
            return response()->json(["error" => "Internal Server Error: $e"], 500);
        }
    }

    public function destroy(UserSubject $userSubject)
    {
        $userSubject->delete();

        return response("", 204);
    }
}
