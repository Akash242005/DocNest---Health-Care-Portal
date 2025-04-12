<?php
session_start();
$conn = new mysqli("localhost", "root", "", "docnest");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve doctor details from GET parameters
$docname = isset($_GET['docname']) ? $_GET['docname'] : '';
$speciality = isset($_GET['speciality']) ? $_GET['speciality'] : '';

// Fetch hospital name and token number from database
$hosname = "Not Provided";
$tokenNumber = 1;
$waitingTime = 0;

$sql = "SELECT hosname, booked FROM doctor WHERE docname = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $docname);
    $stmt->execute();
    $stmt->bind_result($hosname, $existingTokens);
    if ($stmt->fetch()) {
        $tokenNumber = $existingTokens + 1;
        $waitingTime = $existingTokens * 5; // Each appointment takes 5 minutes
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-image: url("https://source.unsplash.com/1920x1080/?hospital,healthcare");
            background-size: cover;
            background-position: center;
            height: 100vh;
            overflow-x: hidden;
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 97, 253, 0.9);
            padding: 15px 30px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar .logo img {
            height: 50px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-links li {
            display: inline;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            padding: 8px 12px;
            transition: 0.3s;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .auth-buttons a {
            background: white;
            color: #005dfd;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        .auth-buttons a:hover {
            background: #003bb3;
            color: white;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
            margin-top: 80px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #218838;
        }

        /* Responsive Navbar */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 10px;
            }
            .nav-links {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            .auth-buttons {
                margin-top: 10px;
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #218838;
        }

    </style>
</head>

<body>

    <nav class="navbar">
        <div class="logo">
            <img src="images/logo1.jpg" alt="Docnest Logo">
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="Hospital.php">Hospitals</a></li>
            <li><a href="Pharmacy.php">Pharmacy</a></li>
            <li><a href="appointment.php">Appointments</a></li>
            <li><a href="order.php">Order</a></li>
        </ul>
        <div class="auth-buttons">
            <a href="login.php">Login</a>
            <a href="#">Sign Up</a>
        </div>
    </nav>

    <div class="container">
        <h2>Book an Appointment</h2>
        <div class="doctor-name">Booking Appointment for: <b><?php echo htmlspecialchars($docname); ?></b></div>
        <p>Speciality: <b><?php echo htmlspecialchars($speciality); ?></b></p>
        <p>Hospital: <b><?php echo htmlspecialchars($hosname); ?></b></p>
        <p>Token Number: <b><?php echo htmlspecialchars($tokenNumber); ?></b></p>
        <p>Estimated Waiting Time: <b><?php echo $waitingTime; ?> minutes</b></p>

        <form id="appointmentForm" action="confirm_appointment.php" method="post">
            <input type="hidden" name="docname" value="<?php echo htmlspecialchars($docname); ?>">
            <input type="hidden" name="hosname" value="<?php echo htmlspecialchars($hosname); ?>">
            <input type="hidden" name="token" value="<?php echo $tokenNumber; ?>">
            <input type="hidden" name="waitingTime" value="<?php echo $waitingTime; ?>">

            <label for="patname">Patient Name:</label>
            <input type="text" id="patname" name="patname" required>

            <label for="disease">Disease / Concern:</label>
            <input type="text" id="disease" name="disease" required>

            <button onclick="confirmAppointment()">Book Appointment</button>
        </form>
    </div>

    <script>
        function confirmAppointment() {
            let tokenNumber = <?php echo $tokenNumber; ?>;
            let waitingTime = <?php echo $waitingTime; ?>;
            
            Swal.fire({
                title: "Appointment Confirmed!",
                html: Your Token Number: <b>${tokenNumber}</b><br>Estimated Waiting Time: <b>${waitingTime} minutes</b>,
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                document.getElementById("appointmentForm").submit();
            });
        }
    </script>
</body>

</html>