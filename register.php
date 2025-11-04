<?php
$error_message = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conn = new mysqli("localhost", "root", "", "first_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error_message = "Username and password are required.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $error_message = "Username has been taken!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $insert_stmt->bind_param("ss", $username, $hashed_password);
            if ($insert_stmt->execute()) {
                echo '<script>alert("Successfully Registered!"); window.location.assign("login.php");</script>';
                exit();
            } else {
                $error_message = "Registration failed!";
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>My first PHP Website</title>
    </head>
    <body>
        <h2>Registration Page</h2>
        <a href="index.php">Click here to go back</a><br/><br/>
        
        <?php if(!empty($error_message)): ?>
        <p style="color:red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="register.php" method="post" autocomplete="off">
           Enter Username: <input type="text" name="username" required="required" autocomplete="off" /> <br/>
           Enter Password: <input type="password" name="password" required="required" autocomplete="off" /> <br/>
           <input type="submit" value="Register"/>
        </form>
    </body>
</html>