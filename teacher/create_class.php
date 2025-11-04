<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Class - Attendance Management System</title>
</head>
<body>
    <h1>Create Class</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<div style='color:red;'>" . htmlspecialchars($_SESSION['error']) . "</div>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<div style='color:green;'>" . htmlspecialchars($_SESSION['success']) . "</div>";
        unset($_SESSION['success']);
    }
    ?>
    <form action="create_class_process.php" method="POST">
        <div>
            <label>Class Name:</label>
            <input type="text" name="class_name" required>
        </div>
        <div>
            <label>Section:</label>
            <input type="text" name="section">
        </div>
        <div>
            <label>Academic Year:</label>
            <input type="text" name="academic_year" placeholder="2025-2026" required>
        </div>
        <button type="submit">Create Class</button>
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>