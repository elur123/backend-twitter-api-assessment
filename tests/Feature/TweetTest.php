<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

use App\Models\User;
use App\Models\Tweet;
class TweetTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_get_tweet_all(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(5), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $guest_user = User::factory()
        ->has(Tweet::factory(5), 'tweets')
        ->create([
            'email' => 'guest@gmail.com'
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->get('/api/v1/tweets');

        $this->assertCount(10, Tweet::all());

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'tweets');
    }

    public function test_get_tweet_using_tweet_uuid(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        Sanctum::actingAs($user, ['*']);

        $response = $this->get('/api/v1/tweets/'.$tweet_one->uuid);

        $response->assertStatus(200);
        $response->assertJsonPath('tweet.uuid', $tweet_one->uuid);
    }

    public function test_create_new_tweet(): void
    {
        $user = User::factory()
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        Sanctum::actingAs($user, ['*']);

        $request = [
            'content' => 'New tweet'
        ];

        $response = $this->post('/api/v1/tweets', $request);

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'tweets');
    }

    public function test_update_tweet_using_tweet_uuid(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        Sanctum::actingAs($user, ['*']);

        $request = [
            'content' => 'test'
        ];

        $response = $this->put('/api/v1/tweets/'.$tweet_one->uuid, $request);

        $response->assertStatus(200);
        $response->assertJsonFragment(['content' => $request['content']]);
    }

    public function test_delete_tweet_using_tweet_uuid(): void
    {
        $user = User::factory()
        ->has(Tweet::factory(3), 'tweets')
        ->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $tweet_one = $user->tweets()
        ->first();

        Sanctum::actingAs($user, ['*']);

        $response = $this->delete('/api/v1/tweets/'.$tweet_one->uuid);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'tweets');
    }
}
