<?php

namespace App\Http\Controllers;

use App\Jobs\CompressDatabaseFile;
use App\Models\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class FileController extends Controller
{
    /**
     * Display a listing of the files.
     *
     * @return File[]|Collection
     */
    public function index()
    {
        return File::orderBy('created_at')->get();
    }

    /**
     * Store a newly uploaded file in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if (!$request->hasFile('content') || !$request->file('content')->isValid()) {
            return response()->json([
                'message' => 'No file was submited or it is not a valid file',
            ], 400);
        }

        $max_upload_size = env('MAX_UPLOAD_SIZE', 20480);
        $content = $request->file('content');
        $name = pathinfo($content->getClientOriginalName(), PATHINFO_FILENAME);

        $data = [
            'name'    => $request->filled('name') ? $request->input('name') : $name,
            'content' => $content,
            'ext'     => strtolower($content->getClientOriginalExtension()),
            'owner'   => $request->user()->id,
        ];

        $validation = Validator::make($data, [
            'name'    => 'required|string|unique:files',
            'content' => "required|file|max:$max_upload_size",
        ], [
            'content.max' => "The file size must not exceed $max_upload_size KB",
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'The data submited contains errors',
                'errors'  => $validation->errors()->all(),
            ], 400);
        }

        // Convert the file contents to hexadecimal in order to accomodate the BYTEA Postgres type
        try {
            $data['content'] = bin2hex($content->get());
        } catch (FileNotFoundException $e) {
            return response()->json([
                'message' => 'There was an error processing the uploaded file',
            ], 500);
        }

        $file = File::create($data);
        CompressDatabaseFile::dispatch($file);

        return response()->json(null, 201);
    }

    /**
     * Display the specified file's properties.
     *
     * @param File $file
     *
     * @return Response
     */
    public function show(File $file)
    {
        return response()->json($file->load('owner:id,name'));
    }

    /**
     * Update the specified file's metadata in storage.
     *
     * @param Request $request
     * @param File $file
     *
     * @return Response
     */
    public function update(Request $request, File $file)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('files')->ignore($file),
            ],
        ]);

        $file->name = $validated['name'];
        $file->save();

        return response()->json();
    }

    /**
     * Download the specified file.
     *
     * @param File $file
     *
     * @return mixed
     */
    public function download(File $file)
    {
        if (!$file->compressed) {
            response()->json([
                'message' => 'The file has not finished compressing on the serveer side',
            ], 500);
        }

        /**
         * Convert the hexadecimal value of the file contents (as stored in the DB)
         * back to its binary form, and prepare the response for download.
         */
        return response(hex2bin(stream_get_contents($file->content)))
            ->header('Content-Type', 'application/zip')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Disposition', 'attachment; filename="' . "{$file->name}.zip" . '";')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Cache-Control', 'no-cache private')
            ->header('Expires', 0);
    }

    /**
     * Remove the specified file from storage.
     *
     * @param File $file
     *
     * @return void
     */
    public function destroy(File $file)
    {
        $file->delete();

        return response()->json(null, 204);
    }
}
