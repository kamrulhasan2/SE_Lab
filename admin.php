<?php
// admin.php
include 'db_config.php';

// SQL to join reservations with item names
$sql = "SELECT r.reservation_id, r.customer_name, r.customer_email, r.reservation_date, r.booking_time, i.name AS item_name, r.created_at
        FROM reservations r
        JOIN items i ON r.item_id = i.item_id
        ORDER BY r.reservation_date DESC, r.booking_time DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - All Reservations</title>
</head>
<body>

    <h1>All Reservations</h1>
    <p><a href="index.php">← Back to Booking Page</a></p>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Item Booked</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date</th>
            <th>Time</th>
            <th>Booked On</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["reservation_id"] . "</td>";
                echo "<td>" . htmlspecialchars($row["item_name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["customer_name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["customer_email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["reservation_date"]) . "</td>";
                // Display time only if it exists
                echo "<td>" . (!empty($row["booking_time"]) ? htmlspecialchars($row["booking_time"]) : '—') . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No reservations found.</td></tr>";
        }
        ?>
    </table>

</body>
</html>
<?php
$conn->close();
?>