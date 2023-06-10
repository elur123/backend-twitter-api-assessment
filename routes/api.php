<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\TweetController;


Route::prefix('v1')->name('v1.')->group(function() {

    Route::prefix('auth')->name('auth.')->group(function () {

        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    });

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('me', [UserController::class, 'showAuthenticatedUser'])->name('me');

        Route::prefix('user')->name('name.')->group(function () {

            Route::get('{user}', [UserController::class, 'show'])->name('show');
            Route::put('{user}', [UserController::class, 'update'])->name('update');
            Route::get('{user}/follower', [UserController::class, 'follower'])->name('follower');
            Route::get('{user}/followed', [UserController::class, 'followed'])->name('followed');
            Route::post('{user}/follow', [UserController::class, 'follow'])->name('follow');
            Route::post('{user}/unfollow', [UserController::class, 'unfollow'])->name('unfollow');
        });

        Route::resource('tweets', TweetController::class);
    });
});
