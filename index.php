<?php
session_start();
require_once 'includes/config.php';

if (isset($_SESSION['teacher_id'])) {
    header("Location: teacher/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teacher Attendance Management System</title>
</head>
<body>
    <h1>Teacher Attendance Management System</h1>
    <div>
        <h2>Teacher Login</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<div style='color: red;'>" . htmlspecialchars($_SESSION['error']) . "</div>";
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo "<div style='color: green;'>" . htmlspecialchars($_SESSION['success']) . "</div>";
            unset($_SESSION['success']);
        }
        ?>
        <form action="teacher/login_process.php" method="POST">
            <div>
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div style="margin-top: 20px;">
            <p>New teacher? <a href="teacher/register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>