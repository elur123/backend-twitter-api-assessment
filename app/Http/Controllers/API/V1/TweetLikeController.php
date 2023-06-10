<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;

use App\Models\Tweet;
use App\Models\TweetLike;
class TweetLikeController extends ApiController
{
    public function show(Tweet $tweet)
    {
        $tweet->load('likes.userLikeBy');

        return response()->json([
            'likes' => $tweet->likes
        ], 200);
    }

    public function addLike(Tweet $tweet)
    {
        $tweet->likes()->firstOrCreate(
            [ 'like_by' => $this->user->id],
            [ 'like_by' => $this->user->id]
        );

        return $this->show($tweet);
    }

    public function delete(Tweet $tweet, TweetLike $like)
    {
        $like->delete();

        return $this->show($tweet);
    }

}
