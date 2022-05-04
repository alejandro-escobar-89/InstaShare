<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FileUpdateTest extends TestCase
{
    public function testUserMustBeAuthenticated()
    {
        $file = File::factory()->create();

        $payload = [
            'name' => 'Test file with new name',
        ];

        $this->putJson("/api/files/{$file->id}", $payload)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testFileNameIsRquired()
    {
        $user = User::factory()->create();

        /**
         * @var HasApiTokens $user
         */
        Sanctum::actingAs($user);

        $file = File::factory()->create();

        $payload = [
            'name' => '',
        ];

        $this->putJson("/api/files/{$file->id}", $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'name' => ['The name field is required.']
                ],
            ]);
    }

    public function testFileNameHasToBeUnique()
    {
        $user = User::factory()->create();

        /**
         * @var HasApiTokens $user
         */
        Sanctum::actingAs($user);

        $file_1 = File::factory()->create();

        $file_2 = File::factory()->create([
            'name' => 'Test file',
        ]);

        $payload = [
            'name' => $file_2->name,
        ];

        $this->putJson("/api/files/{$file_1->id}", $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'name' => ['The name has already been taken.']
                ],
            ]);
    }
}
