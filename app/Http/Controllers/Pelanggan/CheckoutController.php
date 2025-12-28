<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\{Cart, Order, OrderItem, Stock};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product.stock')
            ->where('user_id', auth()->id())
            ->get();

        abort_if($carts->isEmpty(), 404);

        return view('pelanggan.checkout.index', compact('carts'));
    }

    public function process()
    {
        DB::transaction(function () {

            $carts = Cart::with('product.stock')
                ->where('user_id', auth()->id())
                ->get();

            $subtotal = $carts->sum(fn($c) => $c->subtotal());

            $order = Order::create([
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'discount' => 0,
                'total' => $subtotal,
                'status' => 'pending',
                'payment_method' => 'midtrans'
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                    'subtotal' => $cart->subtotal()
                ]);
            }

            Cart::where('user_id', auth()->id())->delete();

            // MIDTRANS
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = false;

            $snapToken = Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => 'AIMI-' . $order->id,
                    'gross_amount' => $order->total
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email
                ]
            ]);

            $order->update(['midtrans_order_id' => 'AIMI-' . $order->id]);

            session(['snap_token' => $snapToken]);
        });

        return redirect()->route('pelanggan.orders');
    }
}
