<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function showTableOrder(string $tableNumber)
    {
        $table = Table::where('number', $tableNumber)->firstOrFail();
        $menus = Menu::with('category')->where('status', 'active')->get();

        return view('orders.table', compact('table', 'menus', 'tableNumber'));
    }

    public function confirmTableOrder(Request $request, string $tableNumber)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array',
            'items.*.quantity' => 'required|integer|min:0',
            'items.*.menu_id' => 'required|integer|exists:menus,id',
        ]);

        $items = collect($validated['items'])->filter(fn ($item) => $item['quantity'] > 0);

        if ($items->isEmpty()) {
            return back()->withErrors(['items' => 'Silakan pilih setidaknya satu menu.'])->withInput();
        }

        $table = Table::where('number', $tableNumber)->firstOrFail();
        $menus = Menu::all()->keyBy('id');
        $total = 0;
        $orderItems = [];

        foreach ($items as $item) {
            $menu = $menus->get($item['menu_id']);
            $quantity = (int) $item['quantity'];
            $subtotal = $menu->price * $quantity;
            $total += $subtotal;

            $orderItems[] = [
                'menu' => $menu,
                'quantity' => $quantity,
                'price' => $menu->price,
                'subtotal' => $subtotal,
            ];
        }

        return view('orders.confirm', [
            'table' => $table,
            'tableNumber' => $tableNumber,
            'customer_name' => $validated['customer_name'],
            'notes' => $validated['notes'],
            'items' => $orderItems,
            'total' => $total,
        ]);
    }

    public function submitTableOrder(Request $request, string $tableNumber)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|json',
            'total' => 'required|numeric|min:0',
        ]);

        $items = json_decode($validated['items'], true);

        $orderNumber = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
        $table = Table::where('number', $tableNumber)->firstOrFail();

        $order = Order::create([
            'order_number' => $orderNumber,
            'table_number' => $table->number,
            'customer_name' => $validated['customer_name'] ?? 'Tamu',
            'notes' => $validated['notes'] ?? null,
            'status' => Order::STATUS_PENDING,
            'total' => $validated['total'],
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        return redirect()->route('orders.payment', ['orderId' => $order->id]);
    }

    public function trackOrder(string $orderId)
    {
        $order = Order::with('items.menu')->findOrFail($orderId);
        $queuePosition = Order::where('status', Order::STATUS_PENDING)
            ->where('created_at', '<=', $order->created_at)
            ->count();

        return view('orders.tracking', compact('order', 'queuePosition'));
    }

    public function paymentPage(string $orderId)
    {
        $order = Order::with('items.menu')->findOrFail($orderId);

        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->route('orders.tracking', ['orderId' => $orderId]);
        }

        return view('orders.payment', compact('order'));
    }

    public function processPayment(Request $request, string $orderId)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:gopay,ovo,dana,linkaja,cash',
            'amount' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($orderId);

        if ((float)$validated['amount'] < (float)$order->total) {
            return back()->withErrors(['amount' => 'Jumlah pembayaran tidak cukup.'])->withInput();
        }

        $change = (float)$validated['amount'] - (float)$order->total;

        $order->update([
            'payment_method' => $validated['payment_method'],
            'paid_amount' => $validated['amount'],
            'change_amount' => $change,
            'status' => Order::STATUS_PAID,
        ]);

        return redirect()->route('orders.tracking', ['orderId' => $order->id])->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
    }

    public function thankyou(string $tableNumber)
    {
        return view('orders.thankyou', compact('tableNumber'));
    }
}
