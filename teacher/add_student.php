<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];
// Fetch classes for this teacher
$query = "SELECT class_id, class_name, section FROM classes WHERE teacher_id = ? AND status = 'active'";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $teacher_id);
mysqli_stmt_execute($stmt);
$classes_result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Student - Attendance Management System</title>
</head>
<body>
    <h1>Add Student</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<div style='color:red;'>" . htmlspecialchars($_SESSION['error']) . "</div>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<div style='color:green;'>" . htmlspecialchars($_SESSION['success']) . "</div>";
        unset($_SESSION['success']);
    }
    ?>
    <form action="add_student_process.php" method="POST">
        <div>
            <label>Select Class:</label>
            <select name="class_id" required>
                <option value="">-- Select class --</option>
                <?php while ($c = mysqli_fetch_assoc($classes_result)) { ?>
                    <option value="<?php echo $c['class_id']; ?>"><?php echo htmlspecialchars($c['class_name'] . ' - ' . $c['section']); ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label>Roll Number:</label>
            <input type="text" name="roll_number" required>
        </div>
        <div>
            <label>Full Name:</label>
            <input type="text" name="full_name" required>
        </div>
        <div>
            <label>Email (optional):</label>
            <input type="email" name="email">
        </div>
        <button type="submit">Add Student</button>
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>