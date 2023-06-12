<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

use App\Models\User;
use App\Models\Tweet;
use App\Models\TweetFile;
class TweetFileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_tweet_files_using_tweet_uuid(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        TweetFile::factory(3)
        ->for($tweet_one)
        ->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->get('/api/v1/tweets/files/'.$tweet_one->uuid);

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'files');
    }

    public function test_attach_files_using_tweet_uuid(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        Sanctum::actingAs($user, ['*']);

        $tempDirectory = storage_path('app/public/temp');
        $imagePath = $this->faker->image($tempDirectory, 360, 360, 'animals', true, true, 'cats', true, 'png');

        $uploadedFiles = [
            new UploadedFile($imagePath, 'example1.png', 'image/png'),
            new UploadedFile($imagePath, 'example2.png', 'image/png'),
            new UploadedFile($imagePath, 'example3.png', 'image/png'),
        ];
    

        $fileResources = array_map(function ($uploadedFile) {
            return fopen($uploadedFile->getPathname(), 'r');
        }, $uploadedFiles);
    
        $request = [
            'files' => array_map(function ($uploadedFile, $fileResource) {
                return new \Illuminate\Http\Testing\File(
                    $uploadedFile->getFilename(),
                    $fileResource
                );
            }, $uploadedFiles, $fileResources),
        ];

        $response = $this->post('/api/v1/tweets/files/'.$tweet_one->uuid, $request);

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'files');
    }

    public function test_delete_file_using_tweet_uuid_and_file_id(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        Sanctum::actingAs($user, ['*']);

        TweetFile::factory(3)
        ->for($tweet_one)
        ->create();

        $file_one = $tweet_one->files()
        ->first();

        $response = $this->delete('/api/v1/tweets/files/'.$tweet_one->uuid .'/'. $file_one->id);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'files');
    }
}
