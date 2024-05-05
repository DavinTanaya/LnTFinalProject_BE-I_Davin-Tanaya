<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'address', 'kodepos', 'status', 'invoice_id', 'total'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function items(){
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }
}

