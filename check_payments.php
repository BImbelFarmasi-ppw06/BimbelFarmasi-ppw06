<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING PAYMENTS ===\n\n";

$payments = \App\Models\Payment::with('order')->get();

echo "Total Payments: " . $payments->count() . "\n\n";

echo "Payment Details:\n";
echo str_repeat("-", 80) . "\n";
printf("%-5s | %-15s | %-12s | %-15s | %-20s\n", "ID", "Order Number", "Status", "Amount", "Created At");
echo str_repeat("-", 80) . "\n";

foreach ($payments as $payment) {
    printf("%-5s | %-15s | %-12s | Rp %-12s | %-20s\n", 
        $payment->id, 
        $payment->order->order_number ?? 'N/A',
        $payment->status,
        number_format($payment->amount, 0, ',', '.'),
        $payment->created_at->format('Y-m-d H:i:s')
    );
}

echo str_repeat("-", 80) . "\n\n";

echo "Status Summary:\n";
$statusCounts = $payments->groupBy('status')->map(function($group) {
    return $group->count();
});

foreach ($statusCounts as $status => $count) {
    echo "  $status: $count payment(s)\n";
}

echo "\n";
