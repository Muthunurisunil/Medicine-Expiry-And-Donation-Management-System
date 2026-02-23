<?php
// login.php
session_start();

$servername = "sql307.infinityfree.com";
$username   = "if0_39907338";
$password   = "Sunil6646";
$dbname     = "if0_39907338_student";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];
    $remember = isset($_POST['remember']); // check if remember me is checked

    $stmt = $conn->prepare("SELECT id, fullname, password, role FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($pass, $row['password'])) {
            // Set session variables
            $_SESSION['user_id']  = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['role']     = $row['role'];

            // Set cookies if "Remember Me" checked (7 days)
            if ($remember) {
                setcookie("user_id", $row['id'], time() + (7 * 24 * 60 * 60), "/");
                setcookie("fullname", $row['fullname'], time() + (7 * 24 * 60 * 60), "/");
                setcookie("role", $row['role'], time() + (7 * 24 * 60 * 60), "/");
            }

            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid Password');</script>";
        }
    } else {
        echo "<script>alert('No account found. Please register.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Medicine Expire Date - Login</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg,#6a11cb,#2575fc);
        height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
    }

    form {
        background:#fff;
        padding:30px 25px;
        border-radius:12px;
        width:360px;
        box-shadow:0 8px 20px rgba(0,0,0,0.2);
    }

    h2 {
        text-align:center;
        color:#333;
        margin-bottom:25px;
    }

    input[type="email"], input[type="password"] {
        width:100%;
        padding:12px;
        margin:10px 0;
        border:1px solid #ccc;
        border-radius:6px;
        font-size:15px;
    }

    label.remember {
        display:flex;
        align-items:center;
        gap:8px;
        font-size:14px;
        margin:10px 0 20px 0;
        cursor:pointer;
    }

    button {
        width:100%;
        padding:12px;
        background:#2575fc;
        border:none;
        color:white;
        font-size:16px;
        border-radius:6px;
        cursor:pointer;
        transition:0.3s;
    }

    button:hover {
        background:#6a11cb;
    }

    p {
        text-align:center;
        margin-top:15px;
        font-size:14px;
    }

    a {
        color:#2575fc;
        text-decoration:none;
        font-weight:bold;
    }

    a:hover {
        text-decoration:underline;
    }
</style>
</head>
<body>
  <form method="POST">
    <h2>Login</h2>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>
    <label class="remember"><input type="checkbox" name="remember"> Remember Me</label>
    <button type="submit">Login</button>
    <p>Don’t have an account? <a href="register.php">Register</a></p>
  </form>
</body>
</html>
