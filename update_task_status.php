<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];

    try {
        // First get the project_id for redirection
        $stmt = $pdo->prepare("SELECT project_id FROM tasks WHERE task_id = ?");
        $stmt->execute([$task_id]);
        $task = $stmt->fetch();
        
        if ($task) {
            $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE task_id = ?");
            $stmt->execute([$status, $task_id]);
            header("Location: view_project.php?id=" . $task['project_id'] . "&success=Task status updated");
        } else {
            header("Location: dashboard.php?error=Task not found");
        }
    } catch(PDOException $e) {
        header("Location: dashboard.php?error=Failed to update task status");
    }
    exit();
}
?>