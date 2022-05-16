<?php

namespace App\Jobs;

use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class CompressDatabaseFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var File
     */
    private $file;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Delete the job if the file no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $original_file_name = "{$this->file->name}.{$this->file->ext}";
        $temp_file_name = 'og_file_temp';
        $zip_file_name = 'zip_file_temp';

        if (env('DB_CONNECTION') == 'pgsql') {
            // Convert the file contents from hexadecimal to binary if they were stored with the BYTEA Postgres type
            $file_binary_content = hex2bin(stream_get_contents($this->file->content));
        } else {
            $file_binary_content = $this->file->content;
        }

        // Create a temporary file to hold the original file content
        Storage::put($temp_file_name, $file_binary_content);

        $zip = new ZipArchive;
        $zip->open(Storage::path($zip_file_name), ZipArchive::CREATE);
        $zip->addFile(Storage::path($temp_file_name), $original_file_name);
        $zip->close();

        // Get the Hex representation of the zipped file in order to accomodate the BYTEA Postgres type
        $zip_content = bin2hex(Storage::get($zip_file_name));

        // Clean up the temp files afterwards
        Storage::delete([$temp_file_name, $zip_file_name]);

        // Update the File model and put it back in the storage (this will trigger a FileUpdated event)
        $this->file->content = $zip_content;
        $this->file->compressed = true;
        $this->file->save();
    }
}
