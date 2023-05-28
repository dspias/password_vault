<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;

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
        return response()->json($this->items());
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

    protected function items()
    {
        $items = Item::with('folder')->get();
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
}
