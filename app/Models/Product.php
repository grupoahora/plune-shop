<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasTags;
    
    protected $fillable = [
        'name',
        'description',
        'price_sale',
        'product_code',
        'status',
        'discount_value',
        'discount_type',
    ];
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
