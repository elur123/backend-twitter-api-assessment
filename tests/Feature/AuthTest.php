<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

use App\Models\User;
class AuthTest extends TestCase
{
    
    use RefreshDatabase;

    public function test_can_register_route(): void
    {
        $request = [
            'name' => 'Jhon Doe',
            'username' => 'jhon',
            'email' => 'jhon123@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];

        $response = $this->post('/api/v1/auth/register', $request);

        $response->assertStatus(200);
    }

    public function test_can_login_route(): void
    {
        $user = User::factory()->create([
            'email' => 'jhon123@gmail.com'
        ]);

        $request = [
            'email' => 'jhon123@gmail.com',
            'password' => '12345678'
        ];

        $response = $this->post('/api/v1/auth/login', $request);

        $response->assertStatus(200);
    }

    public function test_can_logout_route(): void
    {
        $user = User::factory()->create([
            'email' => 'jhon123@gmail.com'
        ]);

        Sanctum::actingAs($user);

        $response = $this->post('/api/v1/auth/logout');

        $response->assertStatus(200);
    }
}
