<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserSubjectController;
use App\Http\Controllers\Api\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/users', UserController::class);

    Route::get('/users/{id}', [UserController::class, 'findById']);

    Route::apiResource('subject', SubjectController::class);

    Route::apiResource('user-subject', UserSubjectController::class);

    Route::get('/user-subject/{id}', [UserSubjectController::class, 'findById']);

    Route::get('/subject/{id}', [SubjectController::class, 'findById']);

    Route::post('/user-subject/set-mark', [UserSubjectController::class, 'updateUsingAccountSubjectIds']);

    Route::get('/users/without-subject/{subjectId}', [UserSubjectController::class, 'getUsersWithoutSubject']);

    Route::get('/user-subject/marks/{users_id}', [UserSubjectController::class, 'userSubjectMarks']);
});

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
