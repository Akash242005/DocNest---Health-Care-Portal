<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get URL parameters if available
$docname = $_GET['docname'] ?? 'Dr. MANOHAR';
$hosname = $_GET['hosname'] ?? 'undefined';
$speciality = $_GET['speciality'] ?? 'General practitioner';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Book an Appointment</h2>
    <form id="appointmentForm" action="confirmation_appointment.php" method="POST">
        <div class="form-group">
            <label for="docname">Doctor Name:</label>
            <input type="text" id="docname" name="docname" value="<?php echo htmlspecialchars($docname); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="hosname">Hospital Name:</label>
            <input type="text" id="hosname" name="hosname" value="<?php echo htmlspecialchars($hosname); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="patname">Patient Name:</label>
            <input type="text" id="patname" name="patname" placeholder="Enter patient name" required>
        </div>
        <div class="form-group">
            <label for="disease">Disease/Reason:</label>
            <input type="text" id="disease" name="disease" placeholder="Enter disease or reason" required>
        </div>
        <button type="button" onclick="confirmAppointment()">Book Appointment</button>
    </form>

    <script>
        function confirmAppointment() {
            const form = document.getElementById('appointmentForm');
            const patname = form.querySelector('input[name="patname"]').value.trim();
            const disease = form.querySelector('input[name="disease"]').value.trim();

            if (!patname || !disease) {
                Swal.fire({
                    title: "Error",
                    text: "Please fill in all required fields.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }

            Swal.fire({
                title: "Confirm Appointment",
                text: `Are you sure you want to book an appointment with ${form.querySelector('input[name="docname"]').value} for ${patname}?`,
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>