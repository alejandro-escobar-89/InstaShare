<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('instashare');

        User::truncate();

        User::create([
            'name'              => 'admin',
            'email'             => 'admin@test.com',
            'email_verified_at' => now(),
            'password'          => $password,
            'remember_token'    => Str::random(10),
        ]);

        User::factory(2)->create();
    }
}
