<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Folder extends Model
{
    use HasFactory;
    
     /**
     * Get the items for the folder.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Item::class, 'folder_id', 'id');
    }
}
