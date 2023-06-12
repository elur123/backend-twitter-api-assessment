<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

use App\Models\User;
use App\Models\FollowedUser;
class FollowedUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_follow_user_using_user_uuid(): void
    {
        $users = User::factory(5)
        ->create();

        $user = $users->first();

        $guest_user = $users->last();

        Sanctum::actingAs($user, ['*']);

        $response = $this->post('/api/v1/user/'.$guest_user->uuid.'/follow');
        
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'user.followed_users');
    }

    public function test_unfollow_user_using_user_uuid(): void
    {
        $users = User::factory(5)
        ->create();

        $user = $users->first();

        $guest_user = $users->last();

        $followedUserAttributes = [
            'follower_id' => $user->id,
            'followed_id' => $guest_user->id,
            
        ];

        FollowedUser::factory()
        ->create($followedUserAttributes);

        $this->assertCount(1, $user->followedUsers);

        Sanctum::actingAs($user, ['*']);

        $response = $this->post('/api/v1/user/'.$guest_user->uuid.'/unfollow');
        
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'user.followed_users');
    }

    public function test_get_user_follower_using_user_uuid(): void
    {
        $users = User::factory(5)
        ->create();

        $user = $users->first();

        $guest_user = $users->last();

        $followedUserAttributes = [
            'follower_id' => $user->id,
            'followed_id' => $guest_user->id,
            
        ];

        FollowedUser::factory()
        ->create($followedUserAttributes);

        Sanctum::actingAs($user, ['*']);

        $response = $this->get('/api/v1/user/'.$guest_user->uuid.'/follower');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'followers');
        $response->assertJsonFragment(['follower_id' => $user->id]);
    }

    public function test_get_user_followed_using_user_uuid(): void
    {
        $users = User::factory(5)
        ->create();

        $user = $users->first();

        $guest_user = $users->last();

        $followedUserAttributes = [
            'follower_id' => $user->id,
            'followed_id' => $guest_user->id,
            
        ];

        FollowedUser::factory()
        ->create($followedUserAttributes);

        Sanctum::actingAs($user, ['*']);

        $response = $this->get('/api/v1/user/'.$user->uuid.'/followed');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'followed');
        $response->assertJsonFragment(['followed_id' => $guest_user->id]);
    }

    public function test_suggested_users_to_follow(): void
    {
        $users = User::factory(5)
        ->create();

        $user = $users->first();

        $guest_user = $users->last();

        $followedUserAttributes = [
            'follower_id' => $user->id,
            'followed_id' => $guest_user->id,
            
        ];

        FollowedUser::factory()
        ->create($followedUserAttributes);

        Sanctum::actingAs($user, ['*']);

        $response = $this->get('/api/v1/user/'.$user->uuid.'/suggestion');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'suggestedUsers');
    }
}
