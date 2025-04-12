<?php
session_start();
include 'db.php';

if (!isset($_SESSION['hospital_id'])) {
    header("Location: hospital_login.php");
    exit();
}

$hospital_id = $_SESSION['hospital_id'];
$hospital_name = $_SESSION['hospital_name'];

// Handle form submission to book an appointment manually
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_name = $_POST['patient_name'];
    $doctor_name = $_POST['doctor_name'];
    $patient_phone = $_POST['patient_phone'];
    $patient_email = $_POST['patient_email'];
    $appointment_time = $_POST['appointment_time'];
    $appointment_date = $_POST['appointment_date'];

    $sql_insert = "INSERT INTO appointments (hospital_id, patient_name, doctor_name, patient_phone, patient_email, appointment_time, appointment_date) 
                   VALUES ('$hospital_id', '$patient_name', '$doctor_name', '$patient_phone', '$patient_email', '$appointment_time', '$appointment_date')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>alert('Appointment booked successfully!'); window.location.href='hospital_admin.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch appointments for this hospital
$sql = "SELECT * FROM appointments WHERE hospital_id='$hospital_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $hospital_name; ?> Admin | DocNest</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f4f6f9; }
        .navbar { background-color: #007bff; }
        .navbar-brand { color: white !important; font-weight: bold; }
        .logout-btn { color: white; border: 1px solid white; }
        .logout-btn:hover { background-color: white; color: #007bff; }
        .container { margin-top: 30px; }
        .table-container, .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand"><?php echo $hospital_name; ?> Admin Panel</a>
        <a href="logout.php" class="btn logout-btn">Logout</a>
    </div>
</nav>

<div class="container">
    <!-- Appointment Booking Form -->
    <div class="form-container">
        <h3 class="text-center mb-3">Book Appointment</h3>
        <form method="post">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Patient Name</label>
                    <input type="text" name="patient_name" class="form-control" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Doctor Name</label>
                    <input type="text" name="doctor_name" class="form-control" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="patient_phone" class="form-control" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="patient_email" class="form-control" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Appointment Time</label>
                    <input type="time" name="appointment_time" class="form-control" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Appointment Date</label>
                    <input type="date" name="appointment_date" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="table-container">
        <h3 class="text-center mb-3">Appointments</h3>
        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Booking Time</th>
                    <th>Appointment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['patient_name']; ?></td>
                    <td><?php echo $row['doctor_name']; ?></td>
                    <td><?php echo $row['patient_phone']; ?></td>
                    <td><?php echo $row['patient_email']; ?></td>
                    <td><?php echo $row['appointment_time']; ?></td>
                    <td><?php echo $row['appointment_date']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>