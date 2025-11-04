<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location: index.php");
        exit();
    }
    $user = $_SESSION['user'];
    $conn = new mysqli("localhost", "root", "", "first_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $details = '';
    $public = 'no';
    $id_exists = false;
    $current_id = 0;

    // Handle POST request to update the item
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id = $_POST['id'];
        $new_details = $_POST['details'];
        $new_public = isset($_POST['public']) && $_POST['public'] == 'yes' ? 'yes' : 'no';

        $stmt = $conn->prepare("UPDATE list SET details = ?, public = ?, date_edited = CURDATE(), time_edited = CURTIME() WHERE id = ? AND user = ?");
        $stmt->bind_param("ssis", $new_details, $new_public, $id, $user);
        $stmt->execute();
        $stmt->close();
        header("location: home.php");
        exit();
    }

    // Handle GET request to display the item for editing
    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
        $id = $_GET['id'];
        $current_id = $id;
        $stmt = $conn->prepare("SELECT * FROM list WHERE id = ? AND user = ?");
        $stmt->bind_param("is", $id, $user);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $id_exists = true;
            $row = $result->fetch_assoc();
            $details = $row['details'];
            $public = $row['public'];
        }
        $stmt->close();
    }
    $conn->close();
?>
<html>
    <head>
        <title>My first PHP Website</title>
    </head>
    <body>
        <h2>Edit Page</h2>
        <p>Hello <?php echo htmlspecialchars($user); ?>!</p>
        <a href="logout.php">Click here to go logout</a><br/><br/>
        <a href="home.php">Return to home page</a>
        <h2 align="center">Edit Item</h2>

        <?php if($id_exists): ?>
            <form action="edit.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($current_id); ?>">
                Enter new detail: <input type="text" name="details" value="<?php echo htmlspecialchars($details); ?>" required /><br/>
                Public post? <input type="checkbox" name="public" value="yes" <?php if($public == 'yes') echo 'checked'; ?> /><br/>
                <input type="submit" value="Update List"/>
            </form>
        <?php else: ?>
            <h2 align="center">Item not found or you don't have permission to edit it.</h2>
        <?php endif; ?>
    </body>
</html>