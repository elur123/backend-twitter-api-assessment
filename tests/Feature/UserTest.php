<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

use App\Models\User;
class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_get_details(): void
    {
        $user = User::factory()->create([
            'email' => 'jhon123@gmail.com'
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->get('/api/v1/me');

        $response->assertStatus(200)
        ->assertJsonPath('user.email', $user->email);
    }

    public function test_user_get_details_using_user_uuid(): void
    {
        $user = User::factory()->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $guest_user = User::factory()->create([
            'email' => 'guest@gmail.com'
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->get('/api/v1/user/'.$guest_user->uuid);

        $response->assertStatus(200)
        ->assertJsonPath('user.email', $guest_user->email);
    }

    public function test_authenticated_user_details_update(): void
    {
        $user = User::factory()->create([
            'name' => 'Jhon Doe',
            'email' => 'jhon123@gmail.com'
        ]);

        Sanctum::actingAs($user, ['*']);

        $request = [
            'name' => 'Jhon Doe',
            'username' => 'jhon_dev',
            'email' => 'jhon_dev@gmail.com'
        ];

        $response = $this->put('/api/v1/user/'.$user->uuid, $request);

        $response->assertStatus(200)
        ->assertJsonPath('user.email', $request['email']);
    }
}
