<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testSanctumReturnsCSRFCookie()
    {
        $this->get('sanctum/csrf-cookie')
            ->assertStatus(Response::HTTP_NO_CONTENT)
            ->assertCookie('XSRF-TOKEN');
    }

    public function testRequiresEmailAndPassword()
    {
        $this->postJson('login')
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

        $this->postJson('/login', $payload)
            ->assertStatus(Response::HTTP_OK);

    }
}
