<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\TweetController;


Route::prefix('v1')->name('v1.')->group(function() {

    Route::prefix('auth')->name('auth.')->group(function () {

        Route::post('register', [AuthController::class, 'register'])->name('register'); // Register user
        Route::post('login', [AuthController::class, 'login'])->name('login'); // Login user
        Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum'); // Logout user
    });

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('me', [UserController::class, 'showAuthenticatedUser'])->name('me'); // Get user authenticated details

        Route::prefix('user')->name('name.')->group(function () {

            Route::get('{user}', [UserController::class, 'show'])->name('show'); // Get user details based on user uuid
            Route::put('{user}', [UserController::class, 'update'])->name('update'); // Update user details based on user uuid
            Route::get('{user}/follower', [UserController::class, 'follower'])->name('follower'); // Get user follower using user uuid
            Route::get('{user}/followed', [UserController::class, 'followed'])->name('followed'); // Get user followed using user uuid
            Route::post('{user}/follow', [UserController::class, 'follow'])->name('follow'); // Authenticated user follow user using user uuid
            Route::post('{user}/unfollow', [UserController::class, 'unfollow'])->name('unfollow'); // Authenticated user unfollow user using user uuid
        });

        Route::resource('tweets', TweetController::class); // Tweet resource route
    });
});
