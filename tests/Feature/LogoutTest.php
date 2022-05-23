<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testUserCanLogout()
    {
        $user = User::factory()->create();

        /**
         * @var HasApiTokens $user
         */
        Sanctum::actingAs($user);
        $this->postjson('/logout')->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
