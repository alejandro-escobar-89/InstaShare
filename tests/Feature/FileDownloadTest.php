<?php

namespace Tests\Feature;

use App\Models\File;
use Illuminate\Http\Response;
use Tests\TestCase;

class FileDownloadTest extends TestCase
{
    public function testFileHasToBeCompressed()
    {
        $file = File::factory()->create([
            'compressed' => false,
        ]);

        $this->get("api/files/download/{$file->id}")
            ->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->assertJson([
                'message' => 'The file has not finished compressing on the server side',
            ]);
    }
}
