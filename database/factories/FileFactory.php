<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'       => Str::of($this->faker->sentence())->rtrim('.'),
            'content'    => $this->faker->sha256(),
            'ext'        => $this->faker->fileExtension(),
            'mime'       => $this->faker->mimeType(),
            'compressed' => $this->faker->boolean(),
            'owner'      => $this->faker->numberBetween(1),
        ];
    }
}
