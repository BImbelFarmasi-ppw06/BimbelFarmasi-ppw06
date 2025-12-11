<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING ORDERS WITHOUT PAYMENTS ===\n\n";

$orders = \App\Models\Order::with('payment')->get();

echo "Total Orders: " . $orders->count() . "\n";
echo "Orders WITHOUT payment: " . $orders->filter(function($o) { return !$o->payment; })->count() . "\n\n";

$ordersWithoutPayment = $orders->filter(function($o) { return !$o->payment; });

if ($ordersWithoutPayment->count() > 0) {
    echo "Creating payment records for orders without payment...\n\n";
    
    foreach ($ordersWithoutPayment as $order) {
        $payment = \App\Models\Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'midtrans',
            'amount' => $order->amount,
            'status' => $order->status === 'completed' ? 'paid' : 'pending',
            'paid_at' => $order->status === 'completed' ? $order->created_at : null,
        ]);
        
        echo "✓ Created payment for Order #{$order->order_number} with status: {$payment->status}\n";
    }
    
    echo "\nDone!\n";
} else {
    echo "All orders already have payment records. ✓\n";
}
