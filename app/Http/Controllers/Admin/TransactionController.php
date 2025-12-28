<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class TransactionController extends Controller
{
    /**
     * Daftar transaksi
     */
    public function index()
    {
        return view('admin.transactions.index', [
            'orders' => Order::with('user')
                ->latest()
                ->get()
        ]);
    }

    /**
     * Detail transaksi
     */
    public function show(Order $order)
    {
        return view('admin.transactions.show', [
            'order' => $order->load('items.product', 'user')
        ]);
    }

    /**
     * Update status manual (EMERGENCY ONLY)
     */
    public function updateStatus(Order $order, $status)
    {
        if (!in_array($status, ['paid', 'cancelled'])) {
            abort(400);
        }

        $order->update([
            'status' => $status
        ]);

        return back()->with('success', 'Status transaksi diperbarui');
    }
}
