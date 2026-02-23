<?php
// register.php
session_start();

$servername = "sql307.infinityfree.com";
$username   = "if0_39907338";
$password   = "Sunil6646";
$dbname     = "if0_39907338_student";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    $pass     = $_POST['password'];
    $cpass    = $_POST['confirm_password'];

    if ($pass !== $cpass) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo "<script>alert('Email already registered. Try logging in.');</script>";
        } else {
            // Hash password and insert
            $hashed = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, 'User')");
            $stmt->bind_param("sss", $fullname, $email, $hashed);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Error registering user.');</script>";
            }

            $stmt->close();
        }
        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - Medicine Expiry Management</title>
<style>
    body { 
        font-family: Arial; 
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
        width: 350px; 
        box-shadow: 0 8px 20px rgba(0,0,0,0.2); 
    }
    h2 { text-align: center; color: #333; }
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
    button:hover { background: #6a11cb; }
    p { text-align: center; }
    a { color: #2575fc; text-decoration: none; }
</style>
</head>
<body>
    <form method="POST">
        <h2>Create Account</h2>
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
</body>
</html>
