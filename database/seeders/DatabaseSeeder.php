<?php

namespace Database\Seeders;

use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // create admin user if not exists
        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // example regular user if not exists
        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
        ]);

        // example categories and menus
        $coffee = \App\Models\Category::firstOrCreate([
            "slug" => "coffee"
        ], [
            "name" => "Coffee",
        ]);

        $snack = \App\Models\Category::firstOrCreate([
            "slug" => "snack"
        ], [
            "name" => "Snack",
        ]);

        \App\Models\Menu::firstOrCreate([
            'name' => 'Cappuccino',
        ], [
            'category_id' => $coffee->id,
            'price' => 25000,
            'description' => 'Kopi hangat dengan busa susu lembut',
            'status' => 'active',
        ]);

        \App\Models\Menu::firstOrCreate([
            'name' => 'Risoles',
        ], [
            'category_id' => $snack->id,
            'price' => 15000,
            'description' => 'Risoles keju dan ayam yang renyah',
            'status' => 'active',
        ]);

        foreach (range(1, 6) as $number) {
            Table::firstOrCreate([
                'number' => (string) $number,
            ], [
                'label' => "Meja $number",
            ]);
        }

        // Create sample orders for reporting
        $cappuccino = \App\Models\Menu::where('name', 'Cappuccino')->first();
        $risoles = \App\Models\Menu::where('name', 'Risoles')->first();
        
        if ($cappuccino && $risoles) {
            // Create a paid order from 10 days ago
            $order1 = \App\Models\Order::create([
                'order_number' => 'ORD-001',
                'table_number' => '1',
                'customer_name' => 'Andi',
                'status' => \App\Models\Order::STATUS_PAID,
                'total' => 75000,
                'payment_method' => 'cash',
                'paid_amount' => 75000,
                'change_amount' => 0,
                'created_at' => now()->subDays(10),
            ]);
            
            \App\Models\OrderItem::create([
                'order_id' => $order1->id,
                'menu_id' => $cappuccino->id,
                'quantity' => 2,
                'price' => 25000,
                'subtotal' => 50000,
            ]);
            
            \App\Models\OrderItem::create([
                'order_id' => $order1->id,
                'menu_id' => $risoles->id,
                'quantity' => 1,
                'price' => 15000,
                'subtotal' => 15000,
            ]);

            // Create another paid order from 5 days ago
            $order2 = \App\Models\Order::create([
                'order_number' => 'ORD-002',
                'table_number' => '2',
                'customer_name' => 'Budi',
                'status' => \App\Models\Order::STATUS_PAID,
                'total' => 75000,
                'payment_method' => 'card',
                'paid_amount' => 75000,
                'change_amount' => 0,
                'created_at' => now()->subDays(5),
            ]);
            
            \App\Models\OrderItem::create([
                'order_id' => $order2->id,
                'menu_id' => $cappuccino->id,
                'quantity' => 3,
                'price' => 25000,
                'subtotal' => 75000,
            ]);

            // Create one pending order
            $order3 = \App\Models\Order::create([
                'order_number' => 'ORD-003',
                'table_number' => '3',
                'customer_name' => 'Citra',
                'status' => \App\Models\Order::STATUS_PENDING,
                'total' => 40000,
                'payment_method' => null,
                'paid_amount' => 0,
                'change_amount' => 0,
                'created_at' => now(),
            ]);
            
            \App\Models\OrderItem::create([
                'order_id' => $order3->id,
                'menu_id' => $risoles->id,
                'quantity' => 2,
                'price' => 15000,
                'subtotal' => 30000,
            ]);
            
            \App\Models\OrderItem::create([
                'order_id' => $order3->id,
                'menu_id' => $cappuccino->id,
                'quantity' => 1,
                'price' => 25000,
                'subtotal' => 25000,
            ]);
        }
    }
}
