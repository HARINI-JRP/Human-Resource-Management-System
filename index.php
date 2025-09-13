<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT hr_id, username, password FROM hr WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if ($password === $row['password']) { // simple match for demo
            $_SESSION['hr'] = $row['username'];
            $_SESSION['hr_id'] = $row['hr_id'];
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = "Invalid credentials";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>HRMS Login</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container center">
    <div class="card">
        <h2>HR Login</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p class="hint">Demo user: admin / admin123</p>
    </div>
</div>
</body>
</html>
