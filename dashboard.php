<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch projects
$stmt = $pdo->prepare("SELECT * FROM projects ORDER BY created_at DESC");
$stmt->execute();
$projects = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Management Dashboard</title>
</head>
<body>
    <h1>Project Management</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> | <a href="logout.php">Logout</a></p>

    <h2>Projects</h2>
    <button>Add New Project</button>

    <div id="addProjectForm">
        <h3>Add New Project</h3>
        <form action="add_project.php" method="POST">
            <p>
                <label for="project_name">Project Name:</label><br>
                <input type="text" id="project_name" name="project_name" required>
            </p>
            <p>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="3"></textarea>
            </p>
            <p>
                <label for="start_date">Start Date:</label><br>
                <input type="date" id="start_date" name="start_date" required>
            </p>
            <p>
                <label for="end_date">End Date:</label><br>
                <input type="date" id="end_date" name="end_date" required>
            </p>
            <p>
                <button type="submit">Add Project</button>
            </p>
        </form>
    </div>

    <?php if (empty($projects)): ?>
        <p>No projects found.</p>
    <?php else: ?>
        <?php foreach ($projects as $project): ?>
            <div>
                <h3><?php echo htmlspecialchars($project['project_name']); ?></h3>
                <p><?php echo htmlspecialchars($project['description']); ?></p>
                <p>Status: <?php echo htmlspecialchars($project['status']); ?></p>
                <p><a href="view_project.php?id=<?php echo $project['project_id']; ?>">View Tasks</a></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>