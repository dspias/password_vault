<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Folder;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use Illuminate\Database\Eloquent\Builder;

class ItemController extends Controller
{
    private string $encriptionKey, $cipher, $iv;

    public function __construct()
    {
        $this->encriptionKey = "HelloVault";
        $this->cipher = "aes-256-cbc";
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $folder_id = $request->input('folder_id');
        return response()->json($this->items($folder_id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'folder_id' => 'nullable',
            'username' => 'required|string',
            'password' => 'required|string',
            'notes' => 'nullable|string|max:600',
        ]);
        
        $item = Item::create([
            'name' => $request->name,
            'username' => $this->encription($request->username),
            'password' => $this->encription($request->password),
        ]);

        $folder_id = $request->input('folder_id');
        if($folder_id && $folder_id != 'no') {
            $item->folder_id = $folder_id;
        }
        if($request->input('notes')) {
            $item->notes = $request->input('notes');
        }
        $item->save();

        return response()->json($this->items());
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'folder_id' => 'nullable',
            'username' => 'required|string',
            'password' => 'required|string',
            'notes' => 'nullable|string|max:600',
        ]);
        
        $item->update([
            'name' => $request->name,
            'username' => $this->encription($request->username),
            'password' => $this->encription($request->password),
        ]);

        $folder_id = $request->input('folder_id');
        if($folder_id && $folder_id != 'no') {
            $item->folder_id = $folder_id;
        } elseif ($folder_id == 'no') {
            $item->folder_id = null;
        }
        if($request->input('notes')) {
            $item->notes = $request->input('notes');
        }
        $item->save();

        return response()->json($this->items());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json($this->items());
    }

    protected function items($folder_id = null)
    {
        if ($folder_id == 'no') {
            $items = Item::whereNull('folder_id')->get();
        } elseif ($folder_id == null) {
            $items = Item::with('folder')->get();
        } else {
            $items = Item::with('folder')->whereFolder_id($folder_id)->get();
        }
        $items->map(function ($item) {
            $item['username'] = $this->decryption($item['username']);
            $item['password'] = $this->decryption($item['password']);
            return $item;
        });
        return ItemResource::collection($items);
    }

    private function encription(string $str): string
    {
        return openssl_encrypt($str, $this->cipher, $this->encriptionKey, 0, $this->iv) . ':' . base64_encode($this->iv);
    }

    private function decryption(string $str): string
    {
        $parts = explode(':', $str);
        $encryptedPassword = $parts[0];
        $iv = base64_decode($parts[1]);
        return openssl_decrypt($encryptedPassword, $this->cipher, $this->encriptionKey, 0, $iv);
    }

    /**
     * Import item from csv files
     */

    public function import(Request $request)
    {
        foreach($request->rows as $row) {
            $item = Item::create([
                'name' => $row['name'],
                'username' => $this->encription($row['username']),
                'password' => $this->encription($row['password']),
            ]);

            if ($row['folder']) {
                $folder = Folder::create([ 'name' => $row['folder'] ]);
                $item->folder_id = $folder->id;
            }
            if($request->input('notes')) {
                $item->notes = $request->input('notes');
            }
            $item->save();
        }
        
        return response()->json($this->items());
    }
}
