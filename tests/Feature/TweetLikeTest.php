<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

use App\Models\User;
use App\Models\Tweet;
use App\Models\TweetLike;
class TweetLikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_tweet_likes_using_tweet_uuid(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        $tweetLikeAttributes = [
            'tweet_id' => $tweet_one->id,
            'like_by' => $user->id,
            
        ];

        TweetLike::factory()
        ->create($tweetLikeAttributes);

        Sanctum::actingAs($user, ['*']);
        
        $response = $this->get('/api/v1/tweets/likes/'.$tweet_one->uuid);

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'likes');
        $response->assertJsonFragment(['like_by' => $user->id]);
    }

    public function test_add_tweet_likes_using_tweet_uuid(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        $tweetLikeAttributes = [
            'tweet_id' => $tweet_one->id,
            'like_by' => $user->id,
        ];

        TweetLike::factory()
        ->create($tweetLikeAttributes);

        Sanctum::actingAs($user, ['*']);
        
        $response = $this->post('/api/v1/tweets/likes/'.$tweet_one->uuid);

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'likes');
        $response->assertJsonFragment(['like_by' => $user->id]);
    }

    public function test_remove_tweet_likes_using_tweet_uuid_and_tweet_like_id(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        $tweetLikeAttributes = [
            'tweet_id' => $tweet_one->id,
            'like_by' => $user->id,
        ];

        TweetLike::factory()
        ->create($tweetLikeAttributes);

        $like_one = $tweet_one->likes()
        ->first();

        Sanctum::actingAs($user, ['*']);
        
        $response = $this->delete('/api/v1/tweets/likes/'.$tweet_one->uuid.'/'.$like_one->id);

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'likes');
    }
}
