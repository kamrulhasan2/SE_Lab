<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $phone = $_POST['phone'];

    $stmt = $pdo->prepare("INSERT INTO doctors (name, specialization, phone) VALUES (?, ?, ?)");
    try {
        $stmt->execute([$name, $specialization, $phone]);
        $message = "Doctor added successfully";
    } catch(PDOException $e) {
        $error = "Error adding doctor: " . $e->getMessage();
    }
}

// Fetch all doctors
$stmt = $pdo->query("SELECT * FROM doctors ORDER BY id DESC");
$doctors = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Doctors - Hospital Management System</title>
</head>
<body>
    <h1>Manage Doctors</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a> |
        <a href="logout.php">Logout</a>
    </nav>

    <?php if (isset($message)) echo "<p>$message</p>"; ?>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>

    <h2>Add New Doctor</h2>
    <form method="POST">
        <div>
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Specialization:</label>
            <input type="text" name="specialization" required>
        </div>
        <div>
            <label>Phone:</label>
            <input type="text" name="phone">
        </div>
        <button type="submit">Add Doctor</button>
    </form>

    <h2>Doctor List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Phone</th>
        </tr>
        <?php foreach ($doctors as $doctor): ?>
        <tr>
            <td><?php echo htmlspecialchars($doctor['id']); ?></td>
            <td><?php echo htmlspecialchars($doctor['name']); ?></td>
            <td><?php echo htmlspecialchars($doctor['specialization']); ?></td>
            <td><?php echo htmlspecialchars($doctor['phone']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>