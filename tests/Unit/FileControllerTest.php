<?php

namespace Tests\Unit;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->getJson('/api/files')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'ext', 'compressed', 'owner', 'created_at'],
            ]);
    }

    public function testStore()
    {
        $this->withoutJobs();

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

        $this->postJson('/api/files', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'name'  => 'Test file',
                'ext'   => 'xyz',
                'owner' => $user->id,
            ]);
    }

    public function testShow()
    {
        $file = File::factory()->create([
            'name' => 'Test file',
            'ext'  => 'xyz',
        ]);

        $this->getJson("/api/files/{$file->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'name'  => $file->name,
                'ext'   => $file->ext,
            ])
            ->assertJsonStructure([
                'id',
                'name',
                'ext',
                'compressed',
                'owner' => ['id', 'name'],
                'created_at',
                'size',
            ]);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();

        /**
         * @var HasApiTokens $user
         */
        Sanctum::actingAs($user);

        $file = File::factory()->create();

        $payload = [
            'name' => 'Test file with new name',
        ];

        $this->putJson("/api/files/{$file->id}", $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'name' => 'Test file with new name',
            ]);
    }

    public function testDownload()
    {
        $file = File::factory()->create([
            'compressed' => true,
        ]);

        $this->get("api/files/download/{$file->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertDownload();
    }

    public function testDestroy()
    {
        $user = User::factory()->create();

        /**
         * @var HasApiTokens $user
         */
        Sanctum::actingAs($user);

        $file = File::factory()->create();

        $this->delete("/api/files/{$file->id}")
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
