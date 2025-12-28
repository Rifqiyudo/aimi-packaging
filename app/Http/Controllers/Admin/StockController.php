<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function update(Request $request, Stock $stock)
    {
        $stock->update([
            'quantity' => $request->quantity
        ]);

        return back()->with('success','Stok diperbarui');
    }
}
