<?php
// process_booking.php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Validate inputs
    if (empty($_POST['item_id']) || empty($_POST['customer_name']) || 
        empty($_POST['customer_email']) || empty($_POST['reservation_date'])) {
        die("Please fill all required fields");
    }

    // 2. Prepare statement with proper parameter binding
    if (!empty($_POST['booking_time'])) {
        $stmt = $conn->prepare("INSERT INTO reservations (item_id, customer_name, customer_email, reservation_date, booking_time) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $item_id, $name, $email, $date, $time);
        $time = $_POST['booking_time'];
    } else {
        $stmt = $conn->prepare("INSERT INTO reservations (item_id, customer_name, customer_email, reservation_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $item_id, $name, $email, $date);
    }

    // 3. Set parameters
    $item_id = intval($_POST['item_id']);
    $name = $_POST['customer_name'];
    $email = $_POST['customer_email'];
    $date = $_POST['reservation_date'];

    // 4. Execute and check result
    echo "<h1>Booking Result</h1>";
    
    if ($stmt->execute()) {
        echo "<p>✅ Success! Your reservation has been booked.</p>";
        echo "<p>Name: " . htmlspecialchars($name) . "</p>";
        echo "<p>Date: " . htmlspecialchars($date) . "</p>";
        if (!empty($_POST['booking_time'])) {
            echo "<p>Time: " . htmlspecialchars($time) . "</p>";
        }
    } else {
        echo "<p>❌ Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    echo "<p><a href='index.php'>Go back to the booking page</a></p>";

} else {
    // Not a POST request
    echo "Access Denied.";
}

$conn->close();
?>