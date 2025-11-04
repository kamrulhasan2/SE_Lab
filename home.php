<?php
    session_start(); //starts the session
    if(!isset($_SESSION['user'])){ // checks if the user is logged in
        header("location: index.php"); // redirects if user is not logged in
    }
    $user = $_SESSION['user']; //assigns user value
?>
<html>
    <head>
        <title>My first PHP Website</title>
    </head>
    <body>
        <h2>Home Page</h2>
        <p>Hello <?php echo $user; ?>!</p> <!--Displays user's name-->
        <a href="logout.php">Click here to go logout</a><br/><br/>
        <form action="add.php" method="POST">
            Add more to list: <input type="text" name="details" /> <br/>
            Public post? <input type="checkbox" name="public[]" value="yes" /> <br/>
            <input type="submit" value="Add to list"/>
        </form>
        <h2 align="center">My list</h2>
        <table border="1px" width="100%">
            <tr>
                <th>Id</th>
                <th>Details</th>
                <th>Post Time</th>
                <th>Edit Time</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Public Post</th>
            </tr>
            <?php
                $conn = new mysqli("localhost", "root", "", "first_db");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                // Prepare statement to avoid SQL injection
                $stmt = $conn->prepare("SELECT * FROM list WHERE user = ? OR public = 'yes'");
                $stmt->bind_param("s", $user);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc())
                    {
                        echo "<tr>";
                        echo '<td align="center">'. $row['id'] . "</td>";
                        echo '<td align="center">'. $row['details'] . "</td>";
                        echo '<td align="center">'. $row['date_posted'] . " - " . $row['time_posted'] . "</td>";
                        // Check if date_edited is null
                        $edit_time = $row['date_edited'] ? $row['date_edited'] . " - " . $row['time_edited'] : "N/A";
                        echo '<td align="center">'. $edit_time ."</td>";
                        echo '<td align="center"><a href="edit.php?id='. $row['id'] .'">edit</a></td>';
                        echo '<td align="center"><a href="delete.php?id='. $row['id'] .'">delete</a></td>';
                        echo '<td align="center">'. $row['public'] . '</td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' align='center'>No items in the list.</td></tr>";
                }
                $stmt->close();
                $conn->close();
            ?>
        </table>
    </body>
</html>