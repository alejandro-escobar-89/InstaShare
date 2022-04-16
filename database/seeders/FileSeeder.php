<?php

namespace Database\Seeders;

use App\Models\File;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        File::truncate();

        for ($i = 0; $i < 20; $i++) {
            File::create([
                'name'       => Str::of($faker->sentence())->rtrim('.'),
                'data'       => $faker->sha256(),
                'compressed' => $faker->boolean(),
            ]);
        }
    }
}
