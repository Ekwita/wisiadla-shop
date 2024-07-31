<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'amount',
        'category_id',
        'image_path_main',
        'image_path_1',
        'image_path_2',
        'image_path_3',
        'image_path_4'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function hasCategory(): bool
    {
        if ($this->category !== null) {
            return true;
        }
        return false;
    }

    public function carts(): HasMany
    {
        return $this->hasMany(ShopCart::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
