<?php
session_start();

// add_medicine.php
if(!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
}

// ✅ Redirect to login if neither session nor cookie exists
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// DB Connection
$servername = "sql307.infinityfree.com"; // Replace with InfinityFree DB Host
$username   = "if0_39907338";            // Your DB Username
$password   = "Sunil6646";               // Your DB Password
$dbname     = "if0_39907338_student";    // Your DB Name

$conn = new mysqli($servername, $username, $password, $dbname);

// Insert data if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicine_name = trim($_POST['medicine_name']);
    $batch_name    = trim($_POST['batch_name']);
    $quantity      = intval($_POST['quantity']);
    $expiry_date   = $_POST['expiry_date']; // yyyy-mm-dd
    $supplier      = trim($_POST['supplier']);

    $stmt = $conn->prepare("INSERT INTO medicines (medicine_name, batch_name, quantity, expiry_date, supplier) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $medicine_name, $batch_name, $quantity, $expiry_date, $supplier);

    if ($stmt->execute()) {
        echo "<script>alert('Medicine added successfully!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Medicine</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg,#6a11cb,#2575fc);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    form {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      width: 400px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #2575fc;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background: #6a11cb;
    }
    a {
      display: block;
      margin-top: 15px;
      text-align: center;
      text-decoration: none;
      color: #2575fc;
    }
  </style>
</head>
<body>
  <form method="POST">
    <h2>Add Medicine</h2>
    <input type="text" name="medicine_name" placeholder="Medicine Name" required>
    <input type="text" name="batch_name" placeholder="Batch Name" required>
    <input type="number" name="quantity" placeholder="Quantity" required>
    <input type="date" name="expiry_date" required>
    <input type="text" name="supplier" placeholder="Supplier Name" required>
    <button type="submit">Add Medicine</button>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
  </form>
</body>
</html>
