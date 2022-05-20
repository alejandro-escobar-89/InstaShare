<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     *
     * @throws FileNotFoundException
     */
    public function definition()
    {
        $content = UploadedFile::fake()->create('test-file.xyz');

        if (env('DB_CONNECTION') == 'pgsql') {
            // Convert the file contents to hexadecimal in order to accomodate the BYTEA Postgres type
            $file_content = bin2hex($content->get());
        } else {
            $file_content = $content->get();
        }

        return [
            'name'       => Str::of($this->faker->sentence())->rtrim('.'),
            'content'    => $file_content,
            'ext'        => $this->faker->fileExtension(),
            'compressed' => false,
            'owner'      => $this->faker->randomElement(User::all())['id'],
        ];
    }
}
