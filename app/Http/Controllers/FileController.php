<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileController extends Controller
{
    /**
     * Display a listing of the files.
     *
     * @return File[]|Collection
     */
    public function index()
    {
        return File::all();
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
        $file = File::create($request->all());

        return response()->json($file, 201);
    }

    /**
     * Display the specified file's properties.
     *
     * @param File $file
     *
     * @return File
     */
    public function show(File $file)
    {
        return $file;
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
        $file->update($request->all());

        return response()->json($file);
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
