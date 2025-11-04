<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Result</title>
</head>
<body>
    <h2>Add Student Result</h2>
    <form method="post" action="add_result_process.php">
        Student Name: <input type="text" name="student_name" required><br><br>
        Subject: <input type="text" name="subject" required><br><br>
        Marks: <input type="number" name="marks" min="0" max="100" required><br><br>
        <input type="submit" value="Add Result">
    </form>
    <br>
    <a href="view_results.php">View Results</a>
</body>
</html>