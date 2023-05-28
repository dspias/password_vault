<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use App\Http\Resources\FolderResource;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->folders());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        
        $folder = Folder::create([
            'name' => $request->name
        ]);

        return response()->json($this->folders());
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder)
    {
        return response()->json(FolderResource::make($folder));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Folder $folder)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        $folder->update($request->only(['name']));

        return response()->json($this->folders());
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
