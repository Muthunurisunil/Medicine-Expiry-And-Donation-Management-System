<?php
// donation_suggestions.php
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

// Show PHP errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sample medicines data
$medicines = [
    ["id" => 1, "medicine_name" => "Paracetamol 500mg", "batch_name" => "BATCH001", "quantity" => 100, "expiry_date" => "2025-12-31", "supplier" => "Sun Pharma"],
    ["id" => 2, "medicine_name" => "Amoxicillin 250mg", "batch_name" => "BATCH002", "quantity" => 50, "expiry_date" => "2025-06-15", "supplier" => "Cipla Ltd"],
    ["id" => 3, "medicine_name" => "Ibuprofen 400mg", "batch_name" => "BATCH003", "quantity" => 200, "expiry_date" => date('Y-m-d', strtotime('+10 days')), "supplier" => "Dr. Reddy Labs"],
    ["id" => 4, "medicine_name" => "Cough Syrup", "batch_name" => "BATCH004", "quantity" => 75, "expiry_date" => "2025-11-20", "supplier" => "Mankind Pharma"],
    ["id" => 5, "medicine_name" => "Vitamin C Tablets", "batch_name" => "BATCH005", "quantity" => 150, "expiry_date" => "2026-01-05", "supplier" => "Zydus Healthcare"],
    ["id" => 6, "medicine_name" => "Azithromycin 250mg", "batch_name" => "BATCH006", "quantity" => 80, "expiry_date" => date('Y-m-d', strtotime('+20 days')), "supplier" => "Cipla Ltd"], // new near expiry
];

// Find near expiry medicines (≤30 days)
$today = strtotime(date('Y-m-d'));
$donation_suggestions = [];

foreach ($medicines as $med) {
    $exp = strtotime($med['expiry_date']);
    $diff_days = ($exp - $today)/(60*60*24);
    
    if ($diff_days > 0 && $diff_days <= 30) {
        $donation_suggestions[] = $med;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation Suggestions</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f9; padding:20px; }
        h2 { text-align:center; color:#2575fc; margin-bottom:10px; }
        p.note { text-align:center; font-size:16px; color:#ff6600; margin-bottom:20px; font-weight:bold; }
        .box {
            background: #fff8e1; /* light yellow for highlight */
            border: 2px solid #ffb300; /* orange border */
            padding: 20px; 
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2); /* stronger shadow */
            width: 80%; 
            max-width: 700px; 
            margin: 0 auto 30px auto;
        }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:10px; border:1px solid #ddd; text-align:center; }
        th { background:#2575fc; color:white; }
        tr:hover { background:#f1f1f1; }
        .back { display:block; margin-top:20px; padding:10px 15px; background:#2575fc; color:white; text-decoration:none; border-radius:6px; text-align:center; width:150px; margin:0 auto; }
        .back:hover { background:#6a11cb; }
        .box h3 { text-align:center; color:#28a745; margin-bottom:15px; }
    </style>
</head>
<body>
    <h2>Donation Suggestions</h2>
    <p class="note">
        These medicines are expiring within the next 30 days. Consider donating them to NGOs, hospitals, or local clinics before expiry.
    </p>

    <div class="box">
        <h3>Medicines Near Expiry (Suggested for Donation)</h3>
        <?php if(count($donation_suggestions) > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Medicine Name</th>
                <th>Batch Name</th>
                <th>Quantity</th>
                <th>Expiry Date</th>
                <th>Supplier</th>
            </tr>
            <?php foreach($donation_suggestions as $med): ?>
            <tr>
                <td><?= htmlspecialchars($med['id']) ?></td>
                <td><?= htmlspecialchars($med['medicine_name']) ?></td>
                <td><?= htmlspecialchars($med['batch_name']) ?></td>
                <td><?= htmlspecialchars($med['quantity']) ?></td>
                <td><?= htmlspecialchars($med['expiry_date']) ?></td>
                <td><?= htmlspecialchars($med['supplier']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p style="text-align:center;">No medicines are near expiry for donation.</p>
        <?php endif; ?>
    </div>

    <a href="dashboard.php" class="back">⬅ Back to Dashboard</a>
</body>
</html>
