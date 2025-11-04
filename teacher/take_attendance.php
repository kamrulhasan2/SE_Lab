<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

// Get classes taught by this teacher
$classes_query = "SELECT * FROM classes WHERE teacher_id = ?";
$stmt = mysqli_prepare($conn, $classes_query);
mysqli_stmt_bind_param($stmt, "i", $teacher_id);
mysqli_stmt_execute($stmt);
$classes_result = mysqli_stmt_get_result($stmt);

// Get today's date
$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Take Attendance - Attendance Management System</title>
</head>
<body>
    <h1>Take Attendance</h1>
    <div>
        <form action="process_attendance.php" method="POST">
            <div>
                <label>Select Class:</label>
                <select name="class_id" required>
                    <option value="">Select a class</option>
                    <?php while ($class = mysqli_fetch_assoc($classes_result)) { ?>
                        <option value="<?php echo $class['class_id']; ?>">
                            <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label>Date:</label>
                <input type="date" name="attendance_date" value="<?php echo $today; ?>" required>
            </div>
            <button type="submit" name="fetch_students">Get Students List</button>
        </form>
    </div>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>