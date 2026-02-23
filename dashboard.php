<?php
session_start();
if(!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['fullname'] = $_COOKIE['fullname'];
    $_SESSION['role'] = $_COOKIE['role'];
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$fullname = $_SESSION['fullname'] ?? "Muthunuri Sunil";
$role = $_SESSION['role'] ?? "Staff";

// ✅ Sample data for dashboard highlights
$total_medicines = 12;
$expired_medicines = 2;
$near_expiry_medicines = 3;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard - Medicine Expiry Management</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f9;
        margin: 0;
        padding: 0;
    }
    header {
        background: linear-gradient(135deg, #2575fc, #6a11cb);
        padding: 25px;
        text-align: center;
        color: white;
        font-size: 24px;
        letter-spacing: 1px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .welcome {
        text-align: center;
        margin: 20px 0;
        font-size: 18px;
        color: #333;
    }
    /* Highlight Cards */
    .stats-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
        margin: 30px auto;
        max-width: 1000px;
    }
    .stat-box {
        flex: 1 1 200px;
        padding: 20px;
        border-radius: 12px;
        color: white;
        text-align: center;
        font-weight: bold;
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        text-decoration: none;
    }
    .stat-box:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,0.25);
    }
    .expired { background: #ff4d4d; }
    .near { background: #ff9800; }
    .total { background: #2575fc; }
    .stat-box i {
        display: block;
        font-size: 35px;
        margin-bottom: 10px;
    }
    .stat-box span {
        display: block;
        font-size: 16px;
        font-weight: normal;
        opacity: 0.9;
    }

    /* Action Cards */
    .actions-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        max-width: 1000px;
        margin: 20px auto 40px;
    }
    .card {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        text-align: center;
        width: 180px;
        text-decoration: none;
        color: #333;
        transition: transform 0.2s, background 0.3s, box-shadow 0.3s;
    }
    .card:hover {
        transform: scale(1.05);
        background: #e9f0ff;
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
    .card i {
        font-size: 35px;
        margin-bottom: 12px;
        color: #2575fc;
    }
    .card span {
        font-weight: bold;
        font-size: 16px;
    }
    .logout {
        display: block;
        margin: 30px auto;
        padding: 12px 20px;
        background: #ff4d4d;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        width: 150px;
        text-align: center;
        transition: 0.3s;
    }
    .logout:hover {
        background: #cc0000;
    }
</style>
</head>
<body>

<header>Medicine Expiry Date Management System</header>

<div class="welcome">
    Welcome, <?= htmlspecialchars($fullname) ?> 👋 <br>
    You are logged in as <b><?= htmlspecialchars($role) ?></b>.
</div>

<!-- ✅ Dashboard Highlight Boxes (Now Clickable) -->
<div class="stats-container">
    <a href="expiry_alerts.php" class="stat-box expired">
        <i class="fas fa-ban"></i>
        <?= $expired_medicines ?>
        <span>Expired Medicines</span>
    </a>
    <a href="expiry_alerts.php" class="stat-box near">
        <i class="fas fa-hourglass-half"></i>
        <?= $near_expiry_medicines ?>
        <span>Near Expiry (≤30 Days)</span>
    </a>
    <a href="view_medicines.php" class="stat-box total">
        <i class="fas fa-pills"></i>
        <?= $total_medicines ?>
        <span>Total Medicines</span>
    </a>
</div>

<!-- ✅ Action Buttons -->
<div class="actions-container">
    <a href="add_medicine.php" class="card"><i class="fas fa-capsules"></i><span>Add Medicine</span></a>
    <a href="view_medicines.php" class="card"><i class="fas fa-tablets"></i><span>View Medicines</span></a>
    <a href="expiry_alerts.php" class="card"><i class="fas fa-triangle-exclamation"></i><span>Expiry Alerts</span></a>
    <a href="donation_suggestions.php" class="card"><i class="fas fa-hand-holding-heart"></i><span>Donation Suggestions</span></a>
    <a href="export_medicines.php" class="card"><i class="fas fa-file-csv"></i><span>Export Medicines</span></a>
    <a href="profile.php" class="card"><i class="fas fa-user-circle"></i><span>My Profile</span></a>
    <a href="medicines_reports.php" class="card"><i class="fas fa-chart-line"></i><span>Medicine Reports</span></a>
    <a href="about_project.php" class="card"><i class="fas fa-info-circle"></i><span>About Project</span></a>
</div>

<a href="logout.php" class="logout">🚪 Logout</a>

</body>
</html>
