<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuCategory extends Model
{
    // include 'image' because controller stores the path on create/update
    protected $fillable = ['name','slug','description','image'];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
