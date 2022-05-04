<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testRequiresNameEmailAndPassword()
    {
        $this->postJson('/register')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => ['name', 'email', 'password'],
            ]);
    }

    public function testRequirePasswordConfirmation()
    {
        $payload = [
            'name'     => 'Test User',
            'email'    => 'test@user.com',
            'password' => 'instashare',
        ];

        $this->postJson('/register', $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => ['The password confirmation does not match.'],
                ],
            ]);
    }

    public function testUserCanRegister()
    {
        $payload = [
            'name'                  => 'Test User',
            'email'                 => 'test@user.com',
            'password'              => 'instashare',
            'password_confirmation' => 'instashare',
        ];

        $this->postJson('/register', $payload)
            ->assertStatus(Response::HTTP_CREATED);
    }
}
