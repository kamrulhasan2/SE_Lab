<?php
session_start();
require_once '../includes/config.php';

if (isset($_SESSION['teacher_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teacher Registration - Attendance Management System</title>
</head>
<body>
    <h1>Teacher Registration</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<div style='color: red;'>" . htmlspecialchars($_SESSION['error']) . "</div>";
        unset($_SESSION['error']);
    }
    ?>
    <form action="register_process.php" method="POST">
        <div>
            <label>Full Name:</label>
            <input type="text" name="full_name" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
        </div>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="../index.php">Login here</a></p>
</body>
</html>