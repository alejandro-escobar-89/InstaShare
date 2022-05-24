<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndPassword()
    {
        $this->postJson('/api/login')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => ['email', 'password']
            ]);
    }

    public function testUserCanLogin()
    {
        $user = User::factory()->create([
            'password' => Hash::make('instashare'),
        ]);

        $payload = [
            'email'    => $user->email,
            'password' => 'instashare',
        ];

        $this->postJson('/api/login', $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['user', 'token']);
    }
}
