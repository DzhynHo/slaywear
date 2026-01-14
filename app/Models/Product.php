<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'category_id',
        'stock',
        'photo',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function formattedPrice(): string
    {
        return number_format((float)$this->price, 2, ',', ' ') . ' zł';
    }

    public function isInStock(): bool
    {
        return (int)$this->stock > 0;
    }
}
