<html>
    <head>
        <title>My first PHP Website</title>
    </head>
    <body>
        <h2>Registration Page</h2>
        <a href="index.php">Click here to go back<br/><br/>
        <form action="register.php" method="post">
           Enter Username: <input type="text" name="username" required="required" /> <br/>
           Enter Password: <input type="password" name="password" required="required" /> <br/>
           <input type="submit" value="Register"/>
        </form>
    </body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conn = new mysqli("localhost", "root", "", "first_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        Print '<script>alert("Username has been taken!");</script>';
        Print '<script>window.location.assign("register.php");</script>';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            Print '<script>alert("Successfully Registered!");</script>';
            Print '<script>window.location.assign("login.php");</script>';
        } else {
            Print '<script>alert("Registration failed!");</script>';
            Print '<script>window.location.assign("register.php");</script>';
        }
    }
    $stmt->close();
    $conn->close();
}
?>