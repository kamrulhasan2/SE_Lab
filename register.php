<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Project Management System</title>
</head>
<body>
    <h2>Register</h2>
    <?php if(isset($_GET['error'])): ?>
        <p><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <form action="register_process.php" method="POST">
        <p>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required>
        </p>
        <p>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required>
        </p>
        <p>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
        </p>
        <p>
            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </p>
        <p>
            <button type="submit">Register</button>
        </p>
    </form>
    <p>Already have an account? <a href="index.php">Login here</a></p>
</body>
</html>