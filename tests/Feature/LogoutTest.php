<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testUserCanLogout()
    {
        $user = User::factory()->create();

        /**
         * @var HasApiTokens $user
         */
        Passport::actingAs($user);

        $this->postjson('/api/logout')->assertStatus(Response::HTTP_OK);
    }
}
