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

// Handle search
if (isset($_POST['view_attendance'])) {
    $class_id = $_POST['class_id'];
    $date = $_POST['date'];

    // Get attendance records
    $attendance_query = "
        SELECT s.roll_number, s.full_name, a.status, a.attendance_date 
        FROM attendance a
        JOIN students s ON a.student_id = s.student_id
        WHERE a.class_id = ? AND a.attendance_date = ?
        ORDER BY s.roll_number";
    
    $stmt = mysqli_prepare($conn, $attendance_query);
    mysqli_stmt_bind_param($stmt, "is", $class_id, $date);
    mysqli_stmt_execute($stmt);
    $attendance_result = mysqli_stmt_get_result($stmt);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Attendance Records - Attendance Management System</title>
</head>
<body>
    <h1>View Attendance Records</h1>

    <!-- Search Form -->
    <div>
        <form method="POST">
            <div>
                <label>Select Class:</label>
                <select name="class_id" required>
                    <option value="">Select a class</option>
                    <?php 
                    mysqli_data_seek($classes_result, 0);
                    while ($class = mysqli_fetch_assoc($classes_result)) { 
                    ?>
                        <option value="<?php echo $class['class_id']; ?>" 
                                <?php if(isset($_POST['class_id']) && $_POST['class_id'] == $class['class_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label>Select Date:</label>
                <input type="date" name="date" required 
                       value="<?php echo isset($_POST['date']) ? $_POST['date'] : date('Y-m-d'); ?>">
            </div>
            <button type="submit" name="view_attendance">View Attendance</button>
        </form>
    </div>

    <!-- Display Attendance Records -->
    <?php if (isset($_POST['view_attendance']) && mysqli_num_rows($attendance_result) > 0) { ?>
        <h3>Attendance for <?php echo $_POST['date']; ?></h3>
        <table>
            <tr>
                <th>Roll Number</th>
                <th>Student Name</th>
                <th>Status</th>
            </tr>
            <?php while ($record = mysqli_fetch_assoc($attendance_result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['roll_number']); ?></td>
                    <td><?php echo htmlspecialchars($record['full_name']); ?></td>
                    <td><?php echo ucfirst($record['status']); ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } elseif (isset($_POST['view_attendance'])) { ?>
        <p>No attendance records found for the selected date.</p>
    <?php } ?>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>