<?php

namespace Database\Factories;

use App\Models\User;
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
            'compressed' => $this->faker->boolean(),
            'owner'      => $this->faker->randomElement(User::all())['id'],
        ];
    }
}
