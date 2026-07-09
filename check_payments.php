<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Payment;
use App\Models\CustomerJob;

$jobs = CustomerJob::where('status', 'completed')->orderBy('id', 'desc')->take(3)->get();
foreach ($jobs as $j) {
    echo "Job #$j->id completed assigned_pro=$j->assigned_pro_id customer=$j->customer_id\n";
    $payments = Payment::where('job_id', $j->id)->get();
    foreach ($payments as $p) {
        echo sprintf("  Payment #%d job=%s status=%s method=%s amount=%s\n",
            $p->id, $p->job_id, var_export($p->status, true), var_export($p->payment_method, true), $p->amount);
    }
    if ($payments->isEmpty()) echo "  (no payments)\n";
}
