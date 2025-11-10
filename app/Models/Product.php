<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'price',
        'negotiable',
        'market_price_range',
        'image',
        'phone',
    ];

    protected $casts = [
        'negotiable' => 'boolean',
        'price' => 'decimal:2',
    ];

    // A product belongs to a user (seller)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
