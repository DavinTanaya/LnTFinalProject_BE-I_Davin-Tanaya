<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home () {
        $list_item = Item::all();
        $carts = Cart::where('user_id', auth()->id())->with('item')->get();
        return view('dashboard', [
            "semuaitem" => $list_item,
            "carts" => $carts,
        ]);
    }
    
}
