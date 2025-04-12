<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "docnest";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch hospital data
$sql = "SELECT id, hosname FROM hospital";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Docnest</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: #f4f7ff;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .admin-container {
            width: 400px;
            margin: 100px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .hospital-list {
            list-style: none;
            padding: 0;
        }

        .hospital-list li {
            background: #007bff;
            color: white;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .hospital-list li:hover {
            background: #0056b3;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
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
            width: 350px;
            text-align: center;
        }

        .modal-content h2 {
            margin-bottom: 20px;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: red;
        }

        .login-btn {
            display: block;
            margin-top: 20px;
            background: #007bff;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .login-btn:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <div class="admin-container">
        <h2>Select Hospital</h2>
        <ul class="hospital-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li onclick='showLogin(" . $row['id'] . ")'>" . htmlspecialchars($row['hosname']) . "</li>";
                }
            } else {
                echo "<p>No hospitals found.</p>";
            }
            ?>
        </ul>
    </div>

    <!-- Hospital Admin Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Hospital Admin Login</h2>
            <p>Please login to continue.</p>
            <a id="loginLink" href="hospital_login.php" class="login-btn">Login</a>
        </div>
    </div>

    <script>
        function showLogin(hospitalId) {
            document.getElementById("loginLink").href = "hospital_login.php?id=" + hospitalId;
            document.getElementById("loginModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("loginModal").style.display = "none";
        }
    </script>

</body>

</html>
