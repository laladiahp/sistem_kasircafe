<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        try {
            $start = $startDate ? Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay() : Carbon::now()->subDays(29)->startOfDay();
        } catch (\Exception $e) {
            $start = Carbon::now()->subDays(29)->startOfDay();
        }

        try {
            $end = $endDate ? Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay() : Carbon::now()->endOfDay();
        } catch (\Exception $e) {
            $end = Carbon::now()->endOfDay();
        }

        if ($start->gt($end)) {
            [$start, $end] = [$end, $start];
        }

        $salesLast30 = Order::selectRaw('DATE(created_at) as date, SUM(total) as total_sales')
            ->where('status', Order::STATUS_PAID)
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $categorySales = OrderItem::selectRaw('categories.name as category, SUM(order_items.subtotal) as revenue')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('categories', 'menus.category_id', '=', 'categories.id')
            ->where('orders.status', Order::STATUS_PAID)
            ->whereBetween('orders.created_at', [$start, $end])
            ->groupBy('categories.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        $topProducts = OrderItem::selectRaw('menus.name as product, SUM(order_items.quantity) as quantity, SUM(order_items.subtotal) as revenue')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->where('orders.status', Order::STATUS_PAID)
            ->whereBetween('orders.created_at', [$start, $end])
            ->groupBy('menus.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        $chartLabels = $salesLast30->pluck('date')->map(fn ($date) => date('d M', strtotime($date)))->all();
        $chartData = $salesLast30->pluck('total_sales')->map(fn ($value) => (float) $value)->all();

        return view('dashboard.reports.index', compact('chartLabels', 'chartData', 'categorySales', 'topProducts', 'start', 'end'));
    }
}
