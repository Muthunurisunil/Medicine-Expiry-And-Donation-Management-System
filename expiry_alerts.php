<?php
// expiry_alerts.php
session_start();

// ✅ Session + Cookie Check
if(!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ Sample Medicines Data (replace with DB later)
$medicines = [
    ["id" => 1, "medicine_name" => "Paracetamol 500mg", "batch_name" => "BATCH001", "quantity" => 100, "expiry_date" => "2025-12-31", "supplier" => "Sun Pharma"],
    ["id" => 2, "medicine_name" => "Amoxicillin 250mg", "batch_name" => "BATCH002", "quantity" => 50, "expiry_date" => "2025-06-15", "supplier" => "Cipla Ltd"],
    ["id" => 3, "medicine_name" => "Ibuprofen 400mg", "batch_name" => "BATCH003", "quantity" => 200, "expiry_date" => date('Y-m-d', strtotime('+10 days')), "supplier" => "Dr. Reddy Labs"],
    ["id" => 4, "medicine_name" => "Cough Syrup", "batch_name" => "BATCH004", "quantity" => 75, "expiry_date" => "2025-11-20", "supplier" => "Mankind Pharma"],
    ["id" => 5, "medicine_name" => "Vitamin C Tablets", "batch_name" => "BATCH005", "quantity" => 150, "expiry_date" => "2026-01-05", "supplier" => "Zydus Healthcare"],
];

// ✅ Example Expired & Near Expiry IDs
$expired_ids = [1, 2, 4];
$near_expiry_ids = [3, 5];

$expired = [];
$near_expiry = [];

foreach ($medicines as $med) {
    if (in_array($med['id'], $expired_ids)) $expired[] = $med;
    elseif (in_array($med['id'], $near_expiry_ids)) $near_expiry[] = $med;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Expiry Alerts | MediSafe</title>
<style>
    body {
        font-family: "Poppins", sans-serif;
        background: linear-gradient(135deg, #2575fc, #6a11cb);
        margin: 0;
        padding: 0;
        color: #333;
    }
    h2 {
        text-align: center;
        color: white;
        margin-top: 30px;
        font-size: 28px;
        letter-spacing: 1px;
    }
    .alerts {
        display: flex;
        flex-direction: column;
        gap: 40px;
        align-items: center;
        margin: 40px auto;
        width: 90%;
        max-width: 1000px;
    }
    .box {
        background: white;
        border-radius: 20px;
        padding: 25px;
        width: 100%;
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .box:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    }
    .box h3 {
        text-align: center;
        margin-bottom: 15px;
        font-size: 22px;
    }
    .expired h3 {
        color: #ff4d4d;
    }
    .near h3 {
        color: #ff9800;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        border-radius: 10px;
        overflow: hidden;
    }
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
        font-size: 15px;
    }
    th {
        background: #2575fc;
        color: white;
        letter-spacing: 0.5px;
    }
    tr:nth-child(even) {
        background: #f9f9f9;
    }

    /* ✅ Color-coded rows */
    .expired-row {
        background-color: #ffe6e6;
        color: #d32f2f;
        font-weight: 500;
    }
    .expired-row:hover {
        background-color: #ffcccc;
    }
    .near-row {
        background-color: #fff5e6;
        color: #e65100;
        font-weight: 500;
    }
    .near-row:hover {
        background-color: #ffe0b2;
    }

    .back {
        display: inline-block;
        margin: 20px auto;
        padding: 12px 25px;
        background: white;
        color: #2575fc;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .back:hover {
        background: #2575fc;
        color: white;
        transform: translateY(-3px);
    }
</style>
</head>
<body>

<h2>💊 Expiry Alerts</h2>

<div class="alerts">
    <div class="box expired">
        <h3>⚠️ Expired Medicines</h3>
        <?php if(count($expired) > 0): ?>
        <table>
            <tr><th>ID</th><th>Name</th><th>Batch</th><th>Quantity</th><th>Expiry Date</th><th>Supplier</th></tr>
            <?php foreach($expired as $med): ?>
            <tr class="expired-row">
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
            <p style="text-align:center; color:#888;">No expired medicines.</p>
        <?php endif; ?>
    </div>

    <div class="box near">
        <h3>⏳ Near Expiry Medicines (≤ 30 Days)</h3>
        <?php if(count($near_expiry) > 0): ?>
        <table>
            <tr><th>ID</th><th>Name</th><th>Batch</th><th>Quantity</th><th>Expiry Date</th><th>Supplier</th></tr>
            <?php foreach($near_expiry as $med): ?>
            <tr class="near-row">
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
            <p style="text-align:center; color:#888;">No medicines near expiry.</p>
        <?php endif; ?>
    </div>
</div>

<div style="text-align:center;">
    <a href="dashboard.php" class="back">⬅ Back to Dashboard</a>
</div>

</body>
</html>
