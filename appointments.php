<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$patient_id, $doctor_id, $appointment_date, $appointment_time]);
        $message = "Appointment scheduled successfully";
    } catch(PDOException $e) {
        $error = "Error scheduling appointment: " . $e->getMessage();
    }
}

// Fetch all appointments with patient and doctor names
$stmt = $pdo->query("
    SELECT 
        a.*,
        p.name as patient_name,
        d.name as doctor_name
    FROM appointments a
    JOIN patients p ON a.patient_id = p.id
    JOIN doctors d ON a.doctor_id = d.id
    ORDER BY a.appointment_date DESC, a.appointment_time DESC
");
$appointments = $stmt->fetchAll();

// Fetch patients and doctors for the form
$patients = $pdo->query("SELECT id, name FROM patients ORDER BY name")->fetchAll();
$doctors = $pdo->query("SELECT id, name, specialization FROM doctors ORDER BY name")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments - Hospital Management System</title>
</head>
<body>
    <h1>Manage Appointments</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a> |
        <a href="logout.php">Logout</a>
    </nav>

    <?php if (isset($message)) echo "<p>$message</p>"; ?>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>

    <h2>Schedule New Appointment</h2>
    <form method="POST">
        <div>
            <label>Patient:</label>
            <select name="patient_id" required>
                <?php foreach ($patients as $patient): ?>
                <option value="<?php echo $patient['id']; ?>">
                    <?php echo htmlspecialchars($patient['name']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Doctor:</label>
            <select name="doctor_id" required>
                <option value="">Select a Doctor</option>
                <?php foreach ($doctors as $doctor): ?>
                <option value="<?php echo $doctor['id']; ?>">
                    <?php echo htmlspecialchars($doctor['name']) . ' - ' . htmlspecialchars($doctor['specialization']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Date:</label>
            <input type="date" name="appointment_date" required>
        </div>
        <div>
            <label>Time:</label>
            <input type="time" name="appointment_time" required>
        </div>
        <button type="submit">Schedule Appointment</button>
    </form>

    <h2>Appointment List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
        <?php foreach ($appointments as $appointment): ?>
        <tr>
            <td><?php echo htmlspecialchars($appointment['id']); ?></td>
            <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
            <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
            <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
            <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
            <td><?php echo htmlspecialchars($appointment['status']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>