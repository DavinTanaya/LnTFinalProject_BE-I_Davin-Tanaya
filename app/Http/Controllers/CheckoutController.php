<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(){
        $carts = Cart::where('user_id', auth()->id())->with('item')->get();

        return view('checkout', [
            "carts" => $carts,
        ]);
    }

    public function clearCart(){
        Cart::where('user_id', auth()->id())->delete();
    }

    public function processCheckout(Request $request){
        $validatedData = $request->validate([
            'alamat' => 'required|string|min:10|max:100',
            'kodepos' => 'required|string|min:5|max:5'
        ]);
        
        $cartItems = Cart::where('user_id', auth()->id())->get();

        foreach($cartItems as $cartItem) {
            if($cartItem->item->jumlah < $cartItem->quantity) {
                return redirect()->back()->with('error', 'Stock barang kurang!!!');
            }
        }

        $order = new Order();
        $order->user_id = auth()->id();
        $order->address = $validatedData['alamat'];
        $order->kodepos = $validatedData['kodepos'];
        date_default_timezone_set('Asia/Jakarta');
        $invoiceId = date("dmYHis") . auth()->id();
        $order->invoice_id = $invoiceId;
        $order->total = $request->total;
        $order->save();

        foreach($cartItems as $cartItem) {
            $item = Item::find($cartItem->item_id);
            $item->jumlah -= $cartItem->quantity;
            $item->save();
            
            $order->items()->attach($item->id, ['quantity' => $cartItem->quantity]);
        }

        $this->clearCart();

        return redirect()->route('dashboard')->with('success', 'Order placed successfully!');
    }
}
