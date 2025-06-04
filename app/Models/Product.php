<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\ProductCategoryEnum;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'categories',
        'description',
        'color',
        'SKU',
        'views',
        'image',
        'sales',
    ];

    protected $casts = [
        'categories' => ProductCategoryEnum::class,
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(orderItem::class);
    }
}
