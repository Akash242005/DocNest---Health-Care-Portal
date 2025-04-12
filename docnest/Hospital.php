<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "docnest"; // Update if your database name is different

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch hospital data
$sql = "SELECT id, hosname, location, image, bed FROM hospital";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospitals - Docnest</title>
    <link rel="stylesheet" href="style.css">
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

        .navbar {
            position: fixed;
            width: 100%;
            height: 70px;
            background: rgba(0, 97, 253, 0.85);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            backdrop-filter: blur(5px);
            z-index: 1000;
        }

        .hospital-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 100px 50px;
            justify-content: center;
        }

        .hospital-card {
            width: 300px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        .hospital-card:hover {
            transform: scale(1.05);
        }

        .hospital-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 3px solid #007bff;
        }

        .hospital-card h3 {
            margin: 10px 0;
            font-size: 20px;
            color: #333;
        }

        .hospital-card p {
            font-size: 16px;
            color: #666;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
            position: relative;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: red;
        }
    </style>
</head>

<body>
<div class="navbar">
        <img src="images/logo1.jpg" alt="Docnest Logo">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="Hospital.php">Hospitals</a>
        <a href="Pharmacy.php">Pharmacy</a>
        <a href="appointment.php">Appointments</a>
        <a href="order.php">Order</a>
        <div class="auth-buttons">
            <a href="login.php" class="login-btn">Login</a>
            <a href="#" class="signup-btn">Sign Up</a>
        </div>
    </div>

    <div class="hospital-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='hospital-card' onclick='getDoctors(" . $row['id'] . ")'>
                        <img src='images/" . htmlspecialchars($row['image']) . "' alt='Hospital Image'>
                        <h3>" . htmlspecialchars($row['hosname']) . "</h3>
                        <p>Location: " . htmlspecialchars($row['location']) . "</p>
                        <p><strong>Beds Available:</strong> " . htmlspecialchars($row['bed']) . "</p>
                      </div>";
            }
        } else {
            echo "<p>No hospitals found.</p>";
        }
        ?>
    </div>

    <!-- Doctor Details Modal -->
    <div id="doctorModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Doctor Details</h2>
            <div id="doctor-details"></div>
        </div>
    </div>

    <script>
    function getDoctors(hospitalId) {
        fetch(`get_doctors.php?id=${hospitalId}`)
            .then(response => response.json())
            .then(data => {
                let modalContent = document.getElementById("doctor-details");
                modalContent.innerHTML = "";

                if (data.error) {
                    modalContent.innerHTML = `<p class='text-danger'>${data.error}</p>`;
                } else {
                    let doctorsHTML = "<ul style='list-style: none; padding: 0;'>";
                    data.forEach(doc => {
                        doctorsHTML += `
                        <li>
                            <strong>${doc.docname}</strong> <br>
                            Specialty: ${doc.specialty} <br>
                            Experience: ${doc.tokens} patients seen <br>
                            Available Time: ${doc.available_time} <br>
                            <a href='appointment.php?docname=${encodeURIComponent(doc.docname)}&speciality=${encodeURIComponent(doc.specialty)}&hosname=${encodeURIComponent(doc.hosname)}' class='book-btn'>Book Appointment</a>
                        </li>
                        <hr>`;
                    });
                    doctorsHTML += "</ul>";
                    modalContent.innerHTML = doctorsHTML;
                }
                document.getElementById("doctorModal").style.display = "flex";
            })
            .catch(error => console.error("Error fetching doctor data:", error));
    }

    function closeModal() {
        document.getElementById("doctorModal").style.display = "none";
    }

    // Ensure modal is hidden on page load
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("doctorModal").style.display = "none";
    });
</script>

</body>

</html>
