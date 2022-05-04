<?php

namespace Tests\Feature;

use App\Jobs\CompressDatabaseFile;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    public function testUserMustBeAuthenticated()
    {
        $user = User::factory()->create();

        $payload = [
            'name'    => 'Test file',
            'content' => UploadedFile::fake()->create('test-file.xyz'),
            'owner'   => $user->id,
        ];

        $this->postJson('/api/files', $payload)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testFileNameHasToBeUnique()
    {
        $user = User::factory()->create();

        /**
         * @var HasApiTokens $user
         */
        Sanctum::actingAs($user);

        File::factory()->create([
            'name' => 'Test file',
        ]);

        $payload = [
            'name'    => 'Test file',
            'content' => UploadedFile::fake()->create('test-file.xyz'),
            'owner'   => $user->id,
        ];

        $this->postJson('/api/files', $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'errors' => ['The name has already been taken.'],
            ]);
    }

    public function testFileHasToBeValid()
    {
        $user = User::factory()->create();

        /**
         * @var HasApiTokens $user
         */
        Sanctum::actingAs($user);

        $payload = [
            'name'    => 'Test file',
            'content' => 'invalid_data',
            'owner'   => $user->id,
        ];

        $this->postJson('/api/files', $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'message' => 'No file was submited or it is not a valid file',
            ]);
    }

    public function testFileMustNotExceedMaxUploadSize()
    {
        $max_upload_size = env('MAX_UPLOAD_SIZE', 51200);
        $user = User::factory()->create();

        /**
         * @var HasApiTokens $user
         */
        Sanctum::actingAs($user);

        $payload = [
            'name'    => 'Test file',
            'content' => UploadedFile::fake()->create('test-file.xyz', $max_upload_size + 1),
            'owner'   => $user->id,
        ];

        $this->postJson('/api/files', $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'errors' => ["The file size must not exceed $max_upload_size KB"],
            ]);
    }

    public function testFileCanBeCompressed()
    {
        Bus::fake();

        $user = User::factory()->create();

        /**
         * @var HasApiTokens $user
         */
        Sanctum::actingAs($user);

        $payload = [
            'name'    => 'Test file',
            'content' => UploadedFile::fake()->create('test-file.xyz'),
            'owner'   => $user->id,
        ];

        $this->postJson('/api/files', $payload);

        Bus::assertDispatched(CompressDatabaseFile::class);
    }
}
