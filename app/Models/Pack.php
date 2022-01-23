<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;
    
    /**
     * Get the wolf entities for the pack.
     */
    public function wolves()
    {
        return $this->hasMany(Wolf::class);
    }
}
