<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Hospital Management System</title>
</head>
<body>
    <h1>Dashboard</h1>
    <nav>
        <a href="patients.php">Manage Patients</a> |
        <a href="doctors.php">Manage Doctors</a> |
        <a href="appointments.php">Manage Appointments</a> |
        <a href="logout.php">Logout</a>
    </nav>
    
    <h2>Welcome, <?php echo htmlspecialchars($role); ?>!</h2>
    <p>Select an option from the menu above to get started.</p>
</body>
</html>