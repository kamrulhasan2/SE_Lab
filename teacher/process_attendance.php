<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../index.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['fetch_students'])) {
        // Get students list for marking attendance
        $class_id = $_POST['class_id'];
        $attendance_date = $_POST['attendance_date'];

        // Check if attendance already taken for this class and date
        $check_query = "SELECT * FROM attendance WHERE class_id = ? AND attendance_date = ?";
        $stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt, "is", $class_id, $attendance_date);
        mysqli_stmt_execute($stmt);
        $check_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $_SESSION['error'] = "Attendance already taken for this class on selected date";
            header("Location: take_attendance.php");
            exit();
        }

        // Get students in the class
        $students_query = "SELECT * FROM students WHERE class_id = ? AND status = 'active'";
        $stmt = mysqli_prepare($conn, $students_query);
        mysqli_stmt_bind_param($stmt, "i", $class_id);
        mysqli_stmt_execute($stmt);
        $students_result = mysqli_stmt_get_result($stmt);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Mark Attendance - Attendance Management System</title>
        </head>
        <body>
            <h1>Mark Attendance</h1>
            <h3>Date: <?php echo $attendance_date; ?></h3>
            
            <form action="process_attendance.php" method="POST">
                <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                <input type="hidden" name="attendance_date" value="<?php echo $attendance_date; ?>">
                <table>
                    <tr>
                        <th>Roll Number</th>
                        <th>Student Name</th>
                        <th>Attendance</th>
                    </tr>
                    <?php while ($student = mysqli_fetch_assoc($students_result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['roll_number']); ?></td>
                            <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                            <td>
                                <select name="attendance[<?php echo $student['student_id']; ?>]" required>
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="late">Late</option>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <button type="submit" name="save_attendance">Save Attendance</button>
            </form>
            <p><a href="take_attendance.php">Back</a></p>
        </body>
        </html>
        <?php
        exit();
    }
    
    if (isset($_POST['save_attendance'])) {
        $class_id = $_POST['class_id'];
        $attendance_date = $_POST['attendance_date'];
        $attendance_data = $_POST['attendance'];

        foreach ($attendance_data as $student_id => $status) {
            $query = "INSERT INTO attendance (student_id, class_id, attendance_date, status, marked_by) 
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "iissi", $student_id, $class_id, $attendance_date, $status, $teacher_id);
            mysqli_stmt_execute($stmt);
        }

        $_SESSION['success'] = "Attendance marked successfully!";
        header("Location: take_attendance.php");
        exit();
    }
}
?>