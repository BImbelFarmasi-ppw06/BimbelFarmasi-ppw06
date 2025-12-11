<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DELETING CANCELLED ORDERS ===\n\n";

// Find all orders with cancelled payments
$orders = \App\Models\Order::with('payment')
    ->whereHas('payment', function($query) {
        $query->where('status', 'cancelled');
    })
    ->get();

echo "Found " . $orders->count() . " cancelled orders\n\n";

if ($orders->count() > 0) {
    foreach ($orders as $order) {
        echo "Deleting Order #{$order->order_number}\n";
        echo "  - Program: {$order->program->name}\n";
        echo "  - Amount: Rp " . number_format($order->amount) . "\n";
        echo "  - Payment Status: {$order->payment->status}\n";
        
        // Delete payment first
        $order->payment->delete();
        echo "  ✓ Payment deleted\n";
        
        // Delete order
        $order->delete();
        echo "  ✓ Order deleted\n\n";
    }
    
    echo "All cancelled orders have been deleted!\n";
} else {
    echo "No cancelled orders found.\n";
}
