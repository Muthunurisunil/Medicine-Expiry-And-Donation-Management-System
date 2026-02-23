<?php
// export_medicines.php
session_start();
if(!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
}

// ✅ Redirect to login if neither session nor cookie exists
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// Show PHP errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sample medicines data (replace with DB fetch if needed)
$medicines = [
    ["id" => 1, "medicine_name" => "Paracetamol 500mg", "batch_name" => "BATCH001", "quantity" => 100, "expiry_date" => "2025-12-31", "supplier" => "Sun Pharma"],
    ["id" => 2, "medicine_name" => "Amoxicillin 250mg", "batch_name" => "BATCH002", "quantity" => 50, "expiry_date" => "2025-06-15", "supplier" => "Cipla Ltd"],
    ["id" => 3, "medicine_name" => "Ibuprofen 400mg", "batch_name" => "BATCH003", "quantity" => 200, "expiry_date" => date('Y-m-d', strtotime('+10 days')), "supplier" => "Dr. Reddy Labs"],
    ["id" => 4, "medicine_name" => "Cough Syrup", "batch_name" => "BATCH004", "quantity" => 75, "expiry_date" => "2025-11-20", "supplier" => "Mankind Pharma"],
    ["id" => 5, "medicine_name" => "Vitamin C Tablets", "batch_name" => "BATCH005", "quantity" => 150, "expiry_date" => "2026-01-05", "supplier" => "Zydus Healthcare"],
    ["id" => 6, "medicine_name" => "Azithromycin 250mg", "batch_name" => "BATCH006", "quantity" => 80, "expiry_date" => date('Y-m-d', strtotime('+20 days')), "supplier" => "Cipla Ltd"],
];

// File name for download
$filename = "medicines_export_" . date('Y-m-d_H-i-s') . ".csv";

// Set headers to force download
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename={$filename}");
header("Content-Type: application/csv");

// Open output stream
$output = fopen('php://output', 'w');

// Column headers
fputcsv($output, ['ID', 'Medicine Name', 'Batch Name', 'Quantity', 'Expiry Date', 'Supplier']);

// Write data rows
foreach ($medicines as $med) {
    fputcsv($output, $med);
}

fclose($output);
exit;
