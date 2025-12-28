<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    /**
     * Laporan penjualan
     */
    public function sales(Request $request)
    {
        $start = $request->start_date ?? Carbon::now()->startOfMonth();
        $end   = $request->end_date ?? Carbon::now()->endOfMonth();

        $orders = Order::with('user')
            ->where('status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $totalRevenue = $orders->sum('total');
        $totalOrders  = $orders->count();

        $bestProducts = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_sold')
            )
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->limit(5)
            ->get();

        return view('admin.reports.sales', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'bestProducts',
            'start',
            'end'
        ));
    }
}
