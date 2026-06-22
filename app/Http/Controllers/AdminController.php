<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;

class AdminController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::count();
        $menusCount = Menu::count();
        $ordersCount = Order::count();
        $pendingOrders = Order::where('status', Order::STATUS_PENDING)->count();
        $tablesCount = Table::count();
        $totalSales = Order::where('status', Order::STATUS_PAID)->sum('total');

        return view('dashboard.admin', compact('categoriesCount', 'menusCount', 'ordersCount', 'pendingOrders', 'tablesCount', 'totalSales'));
    }
}
