<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $created_by = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO projects (project_name, description, start_date, end_date, created_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$project_name, $description, $start_date, $end_date, $created_by]);
        header("Location: dashboard.php?success=Project created successfully");
    } catch(PDOException $e) {
        header("Location: dashboard.php?error=Failed to create project");
    }
    exit();
}
?>