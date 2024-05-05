<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
        'jumlah',
        'image_path',
    ];

    public function Category(){
        return $this->belongsToMany(Category::class, 'item_categories', 'item_id', 'cat_id')->withTimestamps();
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
}
