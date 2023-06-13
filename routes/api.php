<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\TweetController;
use App\Http\Controllers\API\V1\TweetFileController;
use App\Http\Controllers\API\V1\TweetCommentController;
use App\Http\Controllers\API\V1\TweetLikeController;


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
        Route::get('{user}/suggestion', [UserController::class, 'suggestion'])->name('suggestion'); //  List of suggested users to follow using user uuid
        Route::post('{user}/follow', [UserController::class, 'follow'])->name('follow'); // Authenticated user follow user using user uuid
        Route::post('{user}/unfollow', [UserController::class, 'unfollow'])->name('unfollow'); // Authenticated user unfollow user using user uuid
    });

    Route::prefix('tweets')->name('tweets.')->group(function () {

        Route::prefix('files')->name('files.')->group(function () {

            Route::get('{tweet}', [TweetFileController::class, 'show'])->name('show'); // Get tweet files based on tweet uuid
            Route::post('{tweet}', [TweetFileController::class, 'addFiles'])->name('add'); // Add tweet files based on tweet uuid
            Route::delete('{tweet}/{file}', [TweetFileController::class, 'delete'])->name('remove'); // Delete tweet file based on tweet uuid and tweet file id
        });

        Route::prefix('comments')->name('comments.')->group(function () {

            Route::get('{tweet}', [TweetCommentController::class, 'show'])->name('show'); // Get tweet comments based on tweet uuid
            Route::post('{tweet}', [TweetCommentController::class, 'addComments'])->name('add'); // Add tweet comments based on tweet uuid
            Route::put('{tweet}/{comment}', [TweetCommentController::class, 'updateComments'])->name('edit'); // Edit tweet comment based on tweet uuid
            Route::delete('{tweet}/{comment}', [TweetCommentController::class, 'delete'])->name('remove'); // Delete tweet comment based on tweet uuid and tweet comment id
        });

        Route::prefix('likes')->name('likes.')->group(function () {

            Route::get('{tweet}', [TweetLikeController::class, 'show'])->name('show'); // Get tweet likes based on tweet uuid
            Route::post('{tweet}', [TweetLikeController::class, 'addLike'])->name('add'); // Add tweet likes based on tweet uuid
            Route::delete('{tweet}/{like}', [TweetLikeController::class, 'delete'])->name('remove'); // Delete tweet like based on tweet uuid and tweet comment id
        });

    });

    Route::resource('tweets', TweetController::class); // Tweet resource route
});
