<?php

use App\Http\Controllers\Auth\UpdatedUserController;
use App\Http\Controllers\RequestsChambasController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChambaController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::put("/update-profile", [UpdatedUserController::class, 'update']);
    Route::put('/update-password', [UpdatedUserController::class, 'updatePassword']);
    Route::put('/update-jobs', [UpdatedUserController::class, 'updateJobs']);
    Route::get('/show-jobs', [UserController::class, 'showJobs']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/chamba', [ChambaController::class, 'store'])->name('chamba.store');
    Route::get('/chamba/{id}', [ChambaController::class, 'show'])->name('chamba.show');
    Route::delete('/chamba/{id}', [ChambaController::class, 'destroy'])->name('chamba.destroy');
    Route::put('/chamba/{id}', [ChambaController::class, 'update'])->name('chamba.update');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/requests', [RequestsChambasController::class, 'getAllRequests'])->name('requests.index');
    Route::post('/requests', [RequestsChambasController::class, 'store'])->name('requests.store');
    Route::put('/requests-status/{id}', [RequestsChambasController::class, 'updateStatus'])->name('status.update');
});

Route::get('/chamba', [ChambaController::class, 'index'])->name('chamba.index');