<?php
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
    ["id" => 2, "medicine_name" => "Amoxicillin 250mg", "batch_name" => "BATCH002", "quantity" => 50, "expiry_date" => "2025-06-15", "supplier" => "Cipla Ltd"], // expired
    ["id" => 3, "medicine_name" => "Ibuprofen 400mg", "batch_name" => "BATCH003", "quantity" => 200, "expiry_date" => date('Y-m-d', strtotime('+10 days')), "supplier" => "Dr. Reddy Labs"], // near expiry
    ["id" => 4, "medicine_name" => "Cough Syrup", "batch_name" => "BATCH004", "quantity" => 75, "expiry_date" => "2025-11-20", "supplier" => "Mankind Pharma"], // expired
    ["id" => 5, "medicine_name" => "Vitamin C Tablets", "batch_name" => "BATCH005", "quantity" => 150, "expiry_date" => "2026-01-05", "supplier" => "Zydus Healthcare"], // valid
];

$today = strtotime(date('Y-m-d'));
$expired = [];
$near_expiry = [];
$valid = [];

foreach ($medicines as $med) {
    $exp = strtotime($med['expiry_date']);
    $diff_days = ($exp - $today)/(60*60*24);

    if ($exp < $today) {
        $expired[] = $med;
    } elseif ($diff_days <= 30) {
        $near_expiry[] = $med;
    } else {
        $valid[] = $med;
    }
}

// Prepare counts for chart
$total = count($medicines);
$expired_count = count($expired);
$near_expiry_count = count($near_expiry);
$valid_count = count($valid);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medicine Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f9; padding:20px; }
        h2 { text-align:center; color:#2575fc; margin-bottom:20px; }
        .report-box { background:white; padding:20px; border-radius:12px; margin-bottom:30px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        table { width:100%; border-collapse:collapse; margin-top:20px; }
        th, td { padding:10px; border:1px solid #ddd; text-align:center; }
        th { background:#2575fc; color:white; }
        tr.expired { background:#ffcccc; }      /* red for expired */
        tr.near { background:#fff0b3; }         /* orange for near expiry */
        tr.valid { background:#ccffcc; }        /* green for valid */
        tr:hover { background:#f1f1f1; }
        .back { display:block; margin-top:20px; padding:10px 15px; background:#2575fc; color:white; text-decoration:none; border-radius:6px; text-align:center; width:150px; margin-left:auto; margin-right:auto; }
        .back:hover { background:#6a11cb; }
        .chart-container { width:400px; margin:30px auto; }
        .summary { text-align:center; font-size:18px; color:#333; }
        .summary span { font-weight:bold; color:#2575fc; }
    </style>
</head>
<body>
    <h2>Medicine Report (with Pie Chart)</h2>

    <div class="report-box">
        <div class="chart-container">
            <canvas id="medicineChart"></canvas>
        </div>

        <div class="summary">
            <p>Total Medicines: <span><?= $total ?></span></p>
            <p>Expired Medicines: <span><?= $expired_count ?></span></p>
            <p>Near Expiry Medicines: <span><?= $near_expiry_count ?></span></p>
            <p>Valid Medicines: <span><?= $valid_count ?></span></p>
        </div>
    </div>

    <div class="report-box">
        <h3>All Medicines List</h3>
        <table>
            <tr><th>ID</th><th>Name</th><th>Batch</th><th>Qty</th><th>Expiry Date</th><th>Supplier</th></tr>
            <?php foreach ($medicines as $med): 
                $exp = strtotime($med['expiry_date']);
                $diff_days = ($exp - $today)/(60*60*24);
                $class = ($exp < $today) ? 'expired' : (($diff_days <= 30) ? 'near' : 'valid');
            ?>
            <tr class="<?= $class ?>">
                <td><?= htmlspecialchars($med['id']) ?></td>
                <td><?= htmlspecialchars($med['medicine_name']) ?></td>
                <td><?= htmlspecialchars($med['batch_name']) ?></td>
                <td><?= htmlspecialchars($med['quantity']) ?></td>
                <td><?= htmlspecialchars($med['expiry_date']) ?></td>
                <td><?= htmlspecialchars($med['supplier']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <a href="dashboard.php" class="back">⬅ Back to Dashboard</a>

    <script>
    const ctx = document.getElementById('medicineChart').getContext('2d');
    const medicineChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Expired', 'Near Expiry', 'Valid'],
            datasets: [{
                data: [<?= $expired_count ?>, <?= $near_expiry_count ?>, <?= $valid_count ?>],
                backgroundColor: ['#ff4d4d', '#ffc107', '#28a745'],
                borderColor: ['#fff', '#fff', '#fff'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 14 } }
                },
                title: {
                    display: true,
                    text: 'Medicine Expiry Distribution',
                    font: { size: 18 }
                }
            }
        }
    });
    </script>
</body>
</html>
