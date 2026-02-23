<?php
session_start();
// Redirect logged-in users directly to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Medicine Expiry Date Management System - Home</title>
<style>
    body {
        margin:0;
        padding:0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(120deg, #e0f7fa, #e8f5e9);
        color:#333;
    }

    header {
        background: #00838f;
        padding: 20px 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color:white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    header h1 { font-size:24px; }

    nav ul { list-style:none; display:flex; gap:20px; }
    nav ul li a {
        color:white;
        text-decoration:none;
        font-weight:bold;
        padding:5px 10px;
        transition:0.3s;
    }
    nav ul li a:hover { background:white; color:#00838f; border-radius:5px; }

    .hero {
        display:flex;
        flex-wrap:wrap;
        justify-content: center;
        align-items: center;
        padding:60px 50px;
        gap:50px;
        text-align:center;
    }

    .hero-text {
        flex:1;
        max-width:500px;
    }

    .hero-text h2 {
        font-size:36px;
        color:#006064;
        margin-bottom:15px;
    }

    .hero-text p {
        font-size:17px;
        color:#004d40;
        margin-bottom:25px;
        line-height:1.6;
    }

    .hero-text a {
        text-decoration:none;
        background:#006064;
        color:white;
        padding:12px 25px;
        border-radius:8px;
        font-weight:bold;
        transition:0.3s;
    }

    .hero-text a:hover {
        background:#004d40;
    }

    .hero-img img {
        max-width:400px;
        border-radius:15px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }

    .features {
        display:grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap:30px;
        padding:60px 50px;
        background:#e0f2f1;
    }

    .feature-card {
        background:white;
        padding:25px;
        border-radius:12px;
        box-shadow:0 4px 12px rgba(0,0,0,0.1);
        transition:0.3s;
        text-align:center;
    }

    .feature-card:hover {
        transform:translateY(-5px);
        box-shadow:0 8px 20px rgba(0,0,0,0.15);
    }

    .feature-card h3 { color:#00796b; margin-bottom:12px; }
    .feature-card p { color:#004d40; font-size:14px; }

    footer {
        background:#006064;
        color:white;
        text-align:center;
        padding:20px;
        font-size:14px;
    }

    @media(max-width:768px){
        .hero { flex-direction:column; }
    }
</style>
</head>
<body>

<header>
    <h1>MEDMS</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about_project.php">About</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<section class="hero">
    <div class="hero-text">
        <h2>Medicine Expiry Date Management System</h2>
        <p>Track medicine expiry dates, get alerts for near-expiry and expired stock, and suggest safe donations. Make healthcare inventory smarter and efficient.</p>
        <a href="register.php">Get Started</a>
    </div>
    <div class="hero-img">
        <img src="https://cdn-icons-png.flaticon.com/512/2966/2966482.png" alt="Medicine Management">
    </div>
</section>

<section class="features">
    <div class="feature-card">
        <h3>💊 Expiry Alerts</h3>
        <p>Receive timely notifications for expired or near-expiry medicines.</p>
    </div>
    <div class="feature-card">
        <h3>🎁 Donation Suggestions</h3>
        <p>Identify medicines safe for donation and contribute effectively.</p>
    </div>
    <div class="feature-card">
        <h3>📊 Reports & Insights</h3>
        <p>Analyze medicine stock, expiry trends, and usage statistics.</p>
    </div>
    <div class="feature-card">
        <h3>🧾 Audit Logs</h3>
        <p>Track all user activities for transparency and safety.</p>
    </div>
</section>

<footer>
    © 2025 Medicine Expiry Date Management System | Efficient & Safe Healthcare Management
</footer>
 
</body>
</html>
