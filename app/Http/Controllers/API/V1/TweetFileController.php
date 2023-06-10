<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Tweet;
use App\Models\TweetFile;
class TweetFileController extends Controller
{
    
    public function show(Tweet $tweet)
    {
        $tweet->load('files');

        return response()->json([
            'files' => $tweet->files
        ], 200);
    }

    public function addFiles(Request $request, Tweet $tweet)
    {
        $request->validate([
            'files' => ['required','array'],
            'files.*' => ['required','mimetypes:image/jpeg,image/png,video/mp4'],
        ]);

        $files = $request->file('files');

        foreach ($files as $file) 
        {
            $fileName = $file->getClientOriginalName();
            $fileUrl = Storage::putFileAs('public/tweet/'.$tweet->id, $file, $fileName);

            $tweet->files()->create([
                'file_name' => $fileName,
                'file_url' => $fileUrl
            ]);
        }

        return response()->json([
            'files' => $tweet->files
        ], 200);
    }

    public function delete(Tweet $tweet, TweetFile $file)
    {
        if (Storage::exists($file->file_url)) 
        {
            Storage::delete($file->file_url);
        }
        
        $tweet->files()
        ->where('id', $file->id)
        ->delete();

        return response()->json([
            'files' => $tweet->files
        ], 200);
    }
}
