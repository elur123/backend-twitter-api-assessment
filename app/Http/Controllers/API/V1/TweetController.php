<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TweetStoreRequest;

use App\Models\Tweet;
class TweetController extends ApiController
{

    public function index()
    {

        $tweets = Tweet::query()
        ->where('user_id', $this->user->id)
        ->get();

        return response()->json([
            'tweets' => $tweets
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TweetStoreRequest $request)
    {
        $tweet = Tweet::create([
            'user_id' => $this->user->id,
            'content' => $request->content
        ]);

        if ($request->hasFile('files')) 
        {
            $files = $request->file('files');

            foreach ($files as $file) {
                
                $fileName = $file->getClientOriginalName();
                $fileUrl = Storage::putFileAs('public/tweet/'.$tweet->id, $file, $fileName);

                $tweet->files()->create([
                    'file_name' => $fileName,
                    'file_url' => $fileUrl
                ]);
            }
        }

        return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {

        return response()->json([
            'tweet' => $tweet
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TweetStoreRequest $request, Tweet $tweet)
    {
    
        if (!$tweet->user_id === $this->user->id) 
        {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $tweet->update([
            'content' => $request->content
        ]);

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();

        return $this->index();
    }
}
