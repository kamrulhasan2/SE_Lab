<?php
include 'db_config.php';
$sql = "SELECT * FROM results ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Results</title>
</head>
<body>
    <h2>Student Results</h2>
    <a href="add_result.php">Add Result</a><br><br>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Subject</th>
            <th>Marks</th>
        </tr>
        <?php if ($result && $result->num_rows > 0):
            while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
            <td><?php echo htmlspecialchars($row['subject']); ?></td>
            <td><?php echo $row['marks']; ?></td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="4">No results found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>