<?php

use App\Http\Controllers\Auth\UpdatedUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::put("/update-profile", [UpdatedUserController::class, 'update']);
    Route::put('/update-password', [UpdatedUserController::class, 'updatePassword']);
    Route::put('/update-jobs', [UpdatedUserController::class, 'updateJobs']);
    Route::get('/show-jobs', [UserController::class, 'showJobs']);
});