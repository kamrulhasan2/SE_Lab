<?php
include 'db_config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = $conn->real_escape_string($_POST['student_name']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $marks = (int)$_POST['marks'];
    $sql = "INSERT INTO results (student_name, subject, marks) VALUES ('$student_name', '$subject', $marks)";
    if ($conn->query($sql) === TRUE) {
        echo "Result added successfully.<br><a href='add_result.php'>Add Another</a> | <a href='view_results.php'>View Results</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>