<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM hospital WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $hospital = $result->fetch_assoc();
        $_SESSION['hospital_id'] = $hospital['id'];
        $_SESSION['hospital_name'] = $hospital['name'];
        header("Location: hospital_admin.php"); // Redirect to admin page
    } else {
        echo "<script>alert('Invalid credentials!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Login | DocNest</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('hospital-bg.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-weight: bold;
            color: #007bff;
        }
        .form-control {
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .btn-login {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .footer-text {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Hospital Login</h2>
    <form method="POST">
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        <button type="submit" class="btn btn-login">Login</button>
    </form>
    <p class="footer-text">Powered by DocNest</p>
</div>

</body>
</html>
