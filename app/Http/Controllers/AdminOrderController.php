<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.menu')->orderByRaw("FIELD(status, 'pending', 'preparing', 'served', 'paid', 'cancelled')")->orderBy('created_at', 'desc')->get();

        return view('dashboard.orders.index', compact('orders'));
    }

    public function create()
    {
        $menus = Menu::with('category')->where('status', 'active')->get();
        $tables = Table::orderBy('number')->get();

        return view('dashboard.orders.create', compact('menus', 'tables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'customer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array',
            'items.*.quantity' => 'required|integer|min:0',
            'items.*.menu_id' => 'required|integer|exists:menus,id',
        ]);

        $items = collect($validated['items'])->filter(fn($item) => $item['quantity'] > 0);

        if ($items->isEmpty()) {
            return back()->withErrors(['items' => 'Silakan pilih setidaknya satu menu.'])->withInput();
        }

        $table = Table::findOrFail($validated['table_id']);
        $menus = Menu::all()->keyBy('id');
        $total = 0;

        $orderNumber = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));

        $order = Order::create([
            'order_number' => $orderNumber,
            'table_number' => $table->number,
            'customer_name' => $validated['customer_name'] ?? 'Tamu',
            'notes' => $validated['notes'] ?? null,
            'status' => Order::STATUS_PENDING,
            'total' => 0,
        ]);

        foreach ($items as $item) {
            $menu = $menus->get($item['menu_id']);
            $quantity = (int) $item['quantity'];
            $subtotal = $menu->price * $quantity;
            $total += $subtotal;

            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'quantity' => $quantity,
                'price' => $menu->price,
                'subtotal' => $subtotal,
            ]);
        }

        $order->update(['total' => $total]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Pesanan kasir berhasil dibuat.');
    }

    public function show(Order $order)
    {
        return view('dashboard.orders.show', compact('order'));
    }

    public function receipt(Order $order)
    {
        return view('dashboard.orders.receipt', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,preparing,served,paid,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Status pesanan diperbarui.');
    }

    public function pay(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,card,transfer',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        if ($validated['paid_amount'] < $order->total) {
            return back()->withErrors(['paid_amount' => 'Jumlah pembayaran harus sama atau lebih besar dari total.'])->withInput();
        }

        $change = $validated['paid_amount'] - $order->total;

        $order->update([
            'payment_method' => $validated['payment_method'],
            'paid_amount' => $validated['paid_amount'],
            'change_amount' => $change,
            'status' => Order::STATUS_PAID,
        ]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Pembayaran berhasil dicatat.');
    }
}
