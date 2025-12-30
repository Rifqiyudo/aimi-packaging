<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('pelanggan.products')->with('error', 'Keranjang kosong.');
        }

        return view('pelanggan.checkout.index', compact('carts'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string',
            'shipping_method' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $carts = Cart::with('product')->where('user_id', $user->id)->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        // Hitung Total
        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->quantity;
        }

        // GUNAKAN DATABASE TRANSACTION (Agar aman data konsisten)
        DB::transaction(function () use ($request, $user, $carts, $totalPrice) {
            
            // 1. Buat Order
            $order = Order::create([
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
                'total_price' => $totalPrice,
                'status' => 'pending', // Menunggu Konfirmasi Admin
                'address' => $request->address,
                'phone' => $request->phone,
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
            ]);

            // 2. Pindahkan isi Cart ke OrderItems & Kurangi Stok
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);

                // Kurangi Stok Produk
                $cart->product->decrement('stock', $cart->quantity);
            }

            // 3. Kosongkan Keranjang
            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('pelanggan.orders.index')->with('success', 'Pesanan berhasil dibuat! Menunggu konfirmasi admin.');
    }
}