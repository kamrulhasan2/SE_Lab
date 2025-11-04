<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add_student.php');
    exit();
}

$class_id = intval($_POST['class_id']);
$roll_number = mysqli_real_escape_string($conn, $_POST['roll_number']);
$full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
$email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : null;

// Validate
if (empty($class_id) || empty($roll_number) || empty($full_name)) {
    $_SESSION['error'] = 'Please fill required fields.';
    header('Location: add_student.php');
    exit();
}

// Check duplicates
$check = "SELECT * FROM students WHERE roll_number = ? OR (email IS NOT NULL AND email = ?)";
$stmt = mysqli_prepare($conn, $check);
mysqli_stmt_bind_param($stmt, 'ss', $roll_number, $email);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($res) > 0) {
    $_SESSION['error'] = 'Roll number or email already exists.';
    header('Location: add_student.php');
    exit();
}

$insert = "INSERT INTO students (roll_number, full_name, class_id, email, status) VALUES (?, ?, ?, ?, 'active')";
$stmt = mysqli_prepare($conn, $insert);
mysqli_stmt_bind_param($stmt, 'ssis', $roll_number, $full_name, $class_id, $email);
if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = 'Student added successfully.';
    header('Location: add_student.php');
    exit();
} else {
    $_SESSION['error'] = 'Error adding student: ' . mysqli_error($conn);
    header('Location: add_student.php');
    exit();
}
?>