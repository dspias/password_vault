<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\FolderResource;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json($this->folders());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder)
    {
        $folder->load('items');
        return response()->json(FolderResource::make($folder));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Folder $folder)
    {
        dd($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Folder $folder)
    {
        $folder->delete();

        return response()->json($this->folders());
    }

    protected function folders()
    {
        return FolderResource::collection(Folder::all());
    }

}
