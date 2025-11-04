<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = $_POST['project_id'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'] ?: null;
    $due_date = $_POST['due_date'];

    try {
        $stmt = $pdo->prepare("INSERT INTO tasks (project_id, task_name, description, assigned_to, due_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$project_id, $task_name, $description, $assigned_to, $due_date]);
        header("Location: view_project.php?id=" . $project_id . "&success=Task created successfully");
    } catch(PDOException $e) {
        header("Location: view_project.php?id=" . $project_id . "&error=Failed to create task");
    }
    exit();
}
?>