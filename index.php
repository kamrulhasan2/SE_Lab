<?php
// Add these lines at the very top
error_reporting(E_ALL);
ini_set('display_errors', 1);

// index.php
include 'db_config.php';

// Fetch items for display and selection
$items_sql = "SELECT item_id, name, price FROM items";
$items_result = $conn->query($items_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Minimalist Booking System</title>
</head>
<body>

    <h1>Reservation Booking</h1>


    <h2>Available Items/Services</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
        </tr>
        <?php
        if ($items_result->num_rows > 0) {
            while($row = $items_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["item_id"] . "</td>";
                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>$" . number_format($row["price"], 2) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No items available.</td></tr>";
        }
        ?>
    </table>
    <br>
    
    <h2>Make a Reservation</h2>
    <form action="process_booking.php" method="POST">
        
        <label for="item_id">Select Item:</label><br>
        <select name="item_id" id="item_id" required>
            <?php
            // Reset result pointer to populate dropdown
            $items_result->data_seek(0);
            if ($items_result->num_rows > 0) {
                while($row = $items_result->fetch_assoc()) {
                    // Use item_id as the value for processing
                    echo "<option value='" . $row["item_id"] . "'>" . htmlspecialchars($row["name"]) . " ($" . number_format($row["price"], 2) . ")</option>";
                }
            } else {
                 echo "<option value='' disabled>No items available</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="customer_name">Your Name:</label><br>
        <input type="text" id="customer_name" name="customer_name" required>
        <br><br>

        <label for="customer_email">Your Email:</label><br>
        <input type="email" id="customer_email" name="customer_email" required>
        <br><br>

        <label for="reservation_date">Date:</label><br>
        <input type="date" id="reservation_date" name="reservation_date" required>
        <br><br>

        <label for="booking_time">Time (Optional):</label><br>
        <input type="time" id="booking_time" name="booking_time">
        <br><br>

        <input type="submit" value="Confirm Booking">
    </form>
    
    <hr>
    <p><a href="admin.php">View All Reservations (Admin)</a></p>

</body>
</html>
<?php
$conn->close();
?>