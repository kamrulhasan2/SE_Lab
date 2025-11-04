<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Project Management System</title>
</head>
<body>
    <h2>Login</h2>
    <?php if(isset($_GET['error'])): ?>
        <p><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if(isset($_GET['success'])): ?>
        <p><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>
    <form action="login_process.php" method="POST">
        <p>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required>
        </p>
        <p>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
        </p>
        <p>
            <button type="submit">Login</button>
        </p>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>