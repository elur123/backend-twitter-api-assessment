<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

use App\Models\User;
use App\Models\Tweet;
use App\Models\TweetComment;
class TweetCommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_tweet_comments_using_tweet_uuid(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        $tweetCommentAttributes = [
            'comment_by' => $user->id,
            'tweet_id' => $tweet_one->id,
        ];

        TweetComment::factory(3)
        ->create($tweetCommentAttributes);

        Sanctum::actingAs($user, ['*']);
        
        $response = $this->get('/api/v1/tweets/comments/'.$tweet_one->uuid);

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'comments');
    }

    public function test_add_tweet_comment_using_tweet_uuid(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        $request = [
            'comment' => 'test tweet'
        ];

        Sanctum::actingAs($user, ['*']);
        
        $response = $this->post('/api/v1/tweets/comments/'.$tweet_one->uuid, $request);

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'comments');
        $response->assertJsonFragment(['comment' => $request['comment']]);
    }

    public function test_update_tweet_comment_using_tweet_uuid_and_tweet_comment_id(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        $tweetCommentAttributes = [
            'comment_by' => $user->id,
            'tweet_id' => $tweet_one->id,
        ];

        TweetComment::factory(3)
        ->create($tweetCommentAttributes);

        Sanctum::actingAs($user, ['*']);

        $comment_one = $tweet_one->comments()
        ->first();

        $request = [
           'comment' => 'update comment test'
        ];
        
        $response = $this->put('/api/v1/tweets/comments/'.$tweet_one->uuid.'/'.$comment_one->id, $request);

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'comments');
        $response->assertJsonFragment(['comment' => $request['comment']]);
    }

    public function test_delete_tweet_comment_using_tweet_uuid_and_tweet_comment_id(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        $tweetCommentAttributes = [
            'comment_by' => $user->id,
            'tweet_id' => $tweet_one->id,
        ];

        TweetComment::factory(3)
        ->create($tweetCommentAttributes);

        Sanctum::actingAs($user, ['*']);

        $comment_one = $tweet_one->comments()
        ->first();
        
        $response = $this->delete('/api/v1/tweets/comments/'.$tweet_one->uuid.'/'.$comment_one->id);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'comments');
    }
}
