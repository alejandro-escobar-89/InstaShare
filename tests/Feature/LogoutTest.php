<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testUserCanLogout()
    {
        $this->postjson('/logout')->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
