<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('pelanggan.cart.index', [
            'carts' => Cart::with('product')
                ->where('user_id', auth()->id())
                ->get()
        ]);
    }

    public function store(Product $product)
    {
        Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id
            ],
            [
                'quantity' => \DB::raw('quantity + 1')
            ]
        );

        return back()->with('success','Produk ditambahkan ke keranjang');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success','Keranjang diperbarui');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back()->with('success','Item dihapus');
    }
}
