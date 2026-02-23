<?php
session_start();


$fullname = $_SESSION['fullname'] ?? "Muthunuri Sunil";
$role = $_SESSION['role'] ?? "Staff";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About MediSafe</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f9;
        padding: 20px;
        line-height: 1.6;
        color: #333;
    }
    h1 {
        text-align: center;
        color: #2575fc;
    }
    .section {
        max-width: 1000px;
        margin: 20px auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .about-box, .team-box, .purpose-box {
        background: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .team-container {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .team-member {
        flex: 1 1 200px;
        background: #e9f0ff;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.3s;
    }
    .team-member:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
    .team-member h3 {
        margin: 10px 0 5px 0;
        color: #2575fc;
    }
    .team-member p {
        margin: 0;
        font-weight: bold;
        color: #333;
    }
    .back {
        display: block;
        text-align: center;
        margin: 30px auto;
        padding: 12px 20px;
        background: #2575fc;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        width: 150px;
    }
    .back:hover {
        background: #6a11cb;
    }
</style>
</head>
<body>

<h1>Welcome back, <?= htmlspecialchars($fullname) ?>!</h1>
<p style="text-align:center;">Last visit: <?= date('d-m-Y H:i:s') ?></p>

<div class="section">

    <!-- About MediSafe -->
    <div class="about-box">
        <h2>About MediSafe</h2>
        <p>MediSafe is a web-based Medicine Expiry and Stock Management System. It helps hospitals, pharmacies, and clinics efficiently track medicines, manage stock levels, and get alerts for near-expiry and low-stock items.</p>
    </div>

    <!-- Project Team -->
    <div class="team-box">
        <h2>👨‍💻 Project Team</h2>
        <div class="team-container">
            <div class="team-member">
                <h3>Project Lead</h3>
                <p>Muthunuri Sunil</p>
            </div>
            <div class="team-member">
                <h3>Backend Developer</h3>
                <p>Yara Ganesh</p>
            </div>
            <div class="team-member">
                <h3>Frontend Developer</h3>
                <p>M. Bhavitha</p>
            </div>
        </div>
    </div>

    <!-- Purpose -->
    <div class="purpose-box">
        <h2>📌 Purpose</h2>
        <p>The project is designed to reduce medicine wastage, improve inventory visibility, and support timely donations of unused medicines. This ensures better patient care and cost savings for healthcare facilities.</p>
    </div>

</div>

<a href="dashboard.php" class="back">⬅ Back to Dashboard</a>

</body>
</html>
