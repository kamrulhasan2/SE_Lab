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
    <title>Teacher Dashboard - Attendance Management System</title>
</head>
<body>
    <h1>Teacher Dashboard</h1>
    <div>
        Welcome, <?php echo htmlspecialchars($_SESSION['teacher_name']); ?>!
    </div>
    <nav>
        <ul>
            <li><a href="create_class.php">Create Class</a></li>
            <li><a href="add_student.php">Add Student</a></li>
            <li><a href="take_attendance.php">Take Attendance</a></li>
            <li><a href="view_attendance.php">View Attendance Records</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>