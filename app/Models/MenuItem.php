<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_category_id','name','slug','description','price','availability','image_path'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    public function addOns(): BelongsToMany
    {
        return $this->belongsToMany(AddOn::class, 'menu_item_add_on')->withPivot('additional_price');
    }
}
