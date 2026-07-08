<?php
// Quick test script - included inline in the view to debug
try {
    $test = view('partials.notification-bell')->render();
    // If we get here, the view renders
} catch (Throwable $e) {
    echo 'VIEW ERROR: ' . $e->getMessage();
}
