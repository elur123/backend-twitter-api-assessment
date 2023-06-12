<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use App\Http\Resources\TweetCommentResource;

use App\Models\Tweet;
use App\Models\TweetComment;
class TweetCommentController extends ApiController
{
    
    public function show(Tweet $tweet)
    {
        $tweet->load('comments.userCommentBy');

        return response()->json([
            'comments' => TweetCommentResource::collection($tweet->comments) 
        ], 200);
    }

    public function addComments(Request $request, Tweet $tweet)
    {
        $tweet->load('comments.userCommentBy');

        $request->validate([
            'comment' => 'required|string|max:1040'
        ]);

        $tweet->comments()->create([
            'comment_by' => $this->user->id,
            'comment' => $request->comment
        ]);

        return $this->show($tweet);
    }

    public function updateComments(Request $request, Tweet $tweet, TweetComment $comment)
    {
        if (!$this->user->id === $comment->comment_by) 
        {
            return response()->json([
                'message' => 'Invalid action'
            ], 500);
        }

        $tweet->load('comments.userCommentBy');
        
        $request->validate([
            'comment' => 'required|string|max:1040'
        ]);

        $tweet->comments()
        ->where('id', $comment->id)
        ->update([
            'comment' => $request->comment
        ]);

        return $this->show($tweet);
    }

    public function delete(Tweet $tweet, TweetComment $comment)
    {
        $tweet->load('comments.userCommentBy');

        $comment->delete();

        return $this->show($tweet);
    }

}
