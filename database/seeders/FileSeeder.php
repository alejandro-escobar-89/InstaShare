<?php

namespace Database\Seeders;

use App\Jobs\CompressDatabaseFile;
use App\Models\File;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        File::truncate();

        for ($i = 0; $i < 10; $i++) {
            $file = File::factory()->create();
            CompressDatabaseFile::dispatch($file);
        }
    }
}
