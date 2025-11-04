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
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $stmt = $pdo->prepare("INSERT INTO patients (name, age, gender, phone, address) VALUES (?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$name, $age, $gender, $phone, $address]);
        $message = "Patient added successfully";
    } catch(PDOException $e) {
        $error = "Error adding patient: " . $e->getMessage();
    }
}

// Fetch all patients
$stmt = $pdo->query("SELECT * FROM patients ORDER BY id DESC");
$patients = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Patients - Hospital Management System</title>
</head>
<body>
    <h1>Manage Patients</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a> |
        <a href="logout.php">Logout</a>
    </nav>

    <?php if (isset($message)) echo "<p>$message</p>"; ?>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>

    <h2>Add New Patient</h2>
    <form method="POST">
        <div>
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Age:</label>
            <input type="number" name="age" required>
        </div>
        <div>
            <label>Gender:</label>
            <select name="gender" required>
                <option value="M">Male</option>
                <option value="F">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div>
            <label>Phone:</label>
            <input type="text" name="phone">
        </div>
        <div>
            <label>Address:</label>
            <textarea name="address"></textarea>
        </div>
        <button type="submit">Add Patient</button>
    </form>

    <h2>Patient List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Address</th>
        </tr>
        <?php foreach ($patients as $patient): ?>
        <tr>
            <td><?php echo htmlspecialchars($patient['id']); ?></td>
            <td><?php echo htmlspecialchars($patient['name']); ?></td>
            <td><?php echo htmlspecialchars($patient['age']); ?></td>
            <td><?php echo htmlspecialchars($patient['gender']); ?></td>
            <td><?php echo htmlspecialchars($patient['phone']); ?></td>
            <td><?php echo htmlspecialchars($patient['address']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>