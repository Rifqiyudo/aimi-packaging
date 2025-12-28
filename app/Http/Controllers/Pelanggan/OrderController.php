<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return view('pelanggan.orders.index', [
            'orders' => Order::with('items.product')
                ->where('user_id', auth()->id())
                ->latest()
                ->get()
        ]);
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        return view('pelanggan.orders.show', compact('order'));
    }
}
