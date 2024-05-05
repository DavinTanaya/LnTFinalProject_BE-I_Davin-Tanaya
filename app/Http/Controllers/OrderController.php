<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Order;

class OrderController extends Controller
{
    public function orderHistory(){
        $orders = Order::where('user_id', auth()->id())->latest()->get();

        return view('order_history', compact('orders'));
    }

    public function orderDetail($id){
        $order = Order::findOrFail($id);

        if ($order->user_id !== auth()->id() && !auth()->user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access');
        }

        return view('order_detail', compact('order'));
    }

    public function allOrders(){
        if (!auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        $orders = Order::latest()->get();
        return view('order_history', compact('orders'));
    }
}

