<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $salesLast30 = Order::selectRaw('DATE(created_at) as date, SUM(total) as total_sales')
            ->where('status', Order::STATUS_PAID)
            ->where('created_at', '>=', now()->subDays(29))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $categorySales = OrderItem::selectRaw('categories.name as category, SUM(order_items.subtotal) as revenue')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('categories', 'menus.category_id', '=', 'categories.id')
            ->where('orders.status', Order::STATUS_PAID)
            ->groupBy('categories.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        $topProducts = OrderItem::selectRaw('menus.name as product, SUM(order_items.quantity) as quantity, SUM(order_items.subtotal) as revenue')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->where('orders.status', Order::STATUS_PAID)
            ->groupBy('menus.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        $chartLabels = $salesLast30->pluck('date')->map(fn ($date) => date('d M', strtotime($date)))->all();
        $chartData = $salesLast30->pluck('total_sales')->map(fn ($value) => (float) $value)->all();

        return view('dashboard.reports.index', compact('chartLabels', 'chartData', 'categorySales', 'topProducts'));
    }
}
