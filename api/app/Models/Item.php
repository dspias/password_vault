<?php

namespace App\Models;

use App\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    
    /**
     * Get the folder that owns the item.
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'folder_id', 'id');
    }
}
