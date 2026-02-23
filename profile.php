<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// DB connection
$conn = new mysqli("sql307.infinityfree.com", "if0_39907338", "Sunil6646", "if0_39907338_student");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT fullname, email, password FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Update profile when form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $update = $conn->prepare("UPDATE users SET fullname=?, email=?, password=? WHERE id=?");
    $update->bind_param("sssi", $fullname, $email, $password, $user_id);
    if ($update->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f9; padding:30px; }
        h2 { text-align:center; color:#2575fc; margin-bottom:20px; }
        form {
            background:#fff; padding:25px; border-radius:10px; max-width:400px;
            margin:auto; box-shadow:0 4px 12px rgba(0,0,0,0.1);
        }
        label { font-weight:bold; display:block; margin-bottom:5px; }
        input {
            width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc;
            border-radius:6px; font-size:14px;
        }
        button {
            background:#2575fc; color:white; padding:10px; border:none;
            width:100%; border-radius:6px; font-size:16px; cursor:pointer;
        }
        button:hover { background:#6a11cb; }
        .back { display:block; text-align:center; margin-top:15px; color:#2575fc; text-decoration:none; }
        .back:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <h2>My Profile</h2>
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter new password" required>

        <button type="submit">Update Profile</button>
    </form>
    <a href="dashboard.php" class="back">⬅ Back to Dashboard</a>
</body>
</html>
