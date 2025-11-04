<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$project_id = $_GET['id'];

// Fetch project details
$stmt = $pdo->prepare("SELECT * FROM projects WHERE project_id = ?");
$stmt->execute([$project_id]);
$project = $stmt->fetch();

if (!$project) {
    header("Location: dashboard.php");
    exit();
}

// Fetch tasks for this project
$stmt = $pdo->prepare("SELECT t.*, u.username as assigned_to_name FROM tasks t LEFT JOIN users u ON t.assigned_to = u.user_id WHERE t.project_id = ? ORDER BY t.created_at DESC");
$stmt->execute([$project_id]);
$tasks = $stmt->fetchAll();

// Fetch all users for task assignment
$stmt = $pdo->prepare("SELECT user_id, username FROM users");
$stmt->execute();
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Tasks - <?php echo htmlspecialchars($project['project_name']); ?></title>
</head>
<body>
    <div>
        <h1>Project Management</h1>
        <p><a href="dashboard.php">Dashboard</a> | <a href="logout.php">Logout</a></p>
    </div>

    <h2><?php echo htmlspecialchars($project['project_name']); ?></h2>
    <p><?php echo htmlspecialchars($project['description']); ?></p>
    <button>Add New Task</button>

    <div id="addTaskForm">
        <h3>Add New Task</h3>
        <form action="add_task.php" method="POST">
            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
            <p>
                <label for="task_name">Task Name:</label><br>
                <input type="text" id="task_name" name="task_name" required>
            </p>
            <p>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="3"></textarea>
            </p>
            <p>
                <label for="assigned_to">Assign To:</label><br>
                <select id="assigned_to" name="assigned_to">
                    <option value="">Select User</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['user_id']; ?>"><?php echo htmlspecialchars($user['username']); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label for="due_date">Due Date:</label><br>
                <input type="date" id="due_date" name="due_date" required>
            </p>
            <p>
                <button type="submit">Add Task</button>
                <button type="button" onclick="document.getElementById('addTaskForm').style.display='none'">Cancel</button>
            </p>
        </form>
    </div>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Task</th>
                <th>Assigned To</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['task_name']); ?></td>
                    <td><?php echo htmlspecialchars($task['assigned_to_name'] ?? 'Unassigned'); ?></td>
                    <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                    <td><?php echo htmlspecialchars($task['status']); ?></td>
                    <td>
                        <form action="update_task_status.php" method="POST">
                            <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="Pending" <?php echo $task['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="In Progress" <?php echo $task['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Completed" <?php echo $task['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>