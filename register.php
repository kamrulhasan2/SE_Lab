<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    
    // Basic validation
    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $error = "Username already exists";
        } else {
            // Create new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            try {
                $stmt->execute([$username, $hashed_password, $role]);
                $success = "Registration successful! You can now login.";
            } catch(PDOException $e) {
                $error = "Registration failed: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Hospital Management System</title>
</head>
<body>
    <h1>Register New User</h1>
    
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
    
    <form method="POST">
        <div>
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
        </div>
        <div>
            <label>Role:</label>
            <select name="role" required>
                <option value="staff">Staff</option>
                <option value="doctor">Doctor</option>
            </select>
        </div>
        <button type="submit">Register</button>
    </form>
    
    <p>Already have an account? <a href="index.php">Login here</a></p>
</body>
</html>