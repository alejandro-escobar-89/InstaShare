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
            'data'       => $this->faker->sha256(),
            'compressed' => $this->faker->boolean(),
        ];
    }
}
