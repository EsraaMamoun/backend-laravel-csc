<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Requests\CreateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class SubjectController extends Controller
{
    public function index()
    {
        return SubjectResource::collection(Subject::query()->orderBy('id', 'desc')->paginate(10));
    }

    public function show(Subject $subject)
    {
        return new SubjectResource($subject);
    }


    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $data = $request->validated();

        $subject->update($data);

        return new SubjectResource($subject);
    }

    public function store(CreateSubjectRequest $request)
    {
        $data = $request->validated();

        $subject = Subject::create($data);

        return response()->json(['data' => $subject], Response::HTTP_CREATED);
    }

    public function findById($subjectId)
    {
        $subject = Subject::find($subjectId);

        if (!$subject) {
            return response()->json(['error' => 'Subject not found'], 404);
        }

        return new SubjectResource($subject);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return response("", 204);
    }
}
