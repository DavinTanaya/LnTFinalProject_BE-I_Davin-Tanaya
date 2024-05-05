<?php
 
namespace App\Http\Controllers;
 
use App\Models\Cart;
use App\Models\Item;
use App\Models\Product; 
use Illuminate\Http\Request;
 
class CartController extends Controller
{
    public function cart(){
        $carts = Cart::where('user_id', auth()->id())->with('item')->get();

        return view('cart', [
            "carts" => $carts,
        ]);
    }

    public function addToCart($id){
        $userId = auth()->id();
        $item = Item::findOrFail($id);
        $cartItem = Cart::where('user_id', $userId)
                        ->where('item_id', $item->id)
                        ->first();
    
        if ($cartItem) {
            if($item->jumlah > $cartItem->quantity){
                $cartItem->quantity += 1;
                $cartItem->save();
            }
            else{
                return redirect()->back()->with('error', 'Stock terbatas!!');
            }
        } 
        else {
            Cart::create([
                'user_id' => $userId,
                'item_id' => $item->id,
                'quantity' => 1,
            ]);
        }
    
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
 
    public function update(Request $request){
        $validatedData = $request->validate([
            'id' => 'required|exists:carts,id',
            'quantity' => 'required|numeric|min:1'
        ]);
    
        $cart = Cart::findOrFail($validatedData['id']);
        $newQuantity = $validatedData['quantity'];
    
        if($newQuantity <= $cart->item->jumlah) {
            $cart->quantity = $newQuantity;
            $cart->save();
            return redirect()->back()->with('success', 'Cart successfully updated!');
        } else {
            return redirect()->back()->with('error', 'Stock barang kurang!!!');
        }
    }
    
    public function remove(Request $request, $id){
        Cart::destroy($id);
    
        return redirect()->back()->with('success', 'Product successfully removed!');
    }


}