<?php

namespace Tests\Feature;

use App\Models\File;
use Illuminate\Http\Response;
use Tests\TestCase;

class FileDeleteTest extends TestCase
{
    public function testUserMustBeAuthenticated()
    {
        $file = File::factory()->create();

        $this->deleteJson("/api/files/{$file->id}")->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
