<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: create_class.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];
$class_name = mysqli_real_escape_string($conn, $_POST['class_name']);
$section = mysqli_real_escape_string($conn, $_POST['section']);
$academic_year = mysqli_real_escape_string($conn, $_POST['academic_year']);

// Basic validation
if (empty($class_name) || empty($academic_year)) {
    $_SESSION['error'] = 'Class name and academic year are required.';
    header('Location: create_class.php');
    exit();
}

$insert = "INSERT INTO classes (class_name, section, teacher_id, academic_year, status) VALUES (?, ?, ?, ?, 'active')";
$stmt = mysqli_prepare($conn, $insert);
if (!$stmt) {
    $_SESSION['error'] = 'DB error: ' . mysqli_error($conn);
    header('Location: create_class.php');
    exit();
}
mysqli_stmt_bind_param($stmt, 'ssis', $class_name, $section, $teacher_id, $academic_year);
if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = 'Class created successfully!';
    header('Location: dashboard.php');
    exit();
} else {
    $_SESSION['error'] = 'Error creating class: ' . mysqli_error($conn);
    header('Location: create_class.php');
    exit();
}
?>