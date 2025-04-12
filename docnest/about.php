<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | DocNest</title>
    <link rel="icon" href="images/doclogo.jpeg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Navbar Styles */
        .navbar {
            background: rgba(0, 97, 253, 0.9);
            padding: 15px 30px;
        }
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }
        .nav-link {
            color: white !important;
            font-weight: 500;
            transition: 0.3s;
        }
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 5px 10px;
        }
        .auth-buttons a {
            background: white;
            color: #0061fd;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }
        .auth-buttons a:hover {
            background: #004db3;
            color: white;
        }

        /* Hero Section */
        .hero {
            position: relative;
            background: url("https://source.unsplash.com/1600x900/?doctor,hospital") center/cover no-repeat;
            height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: black;
            font-size: 1.8rem;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(77, 138, 235, 0.85);
        }

        /* Section Styling */
        .section-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .section-text {
            text-align: center;
            font-size: 1.1rem;
            color: #555;
            max-width: 800px;
            margin: 0 auto 30px;
        }

        /* Team Section */
        .team-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #0061fd;
        }
        .team-member {
            text-align: center;
            margin-bottom: 30px;
        }
        .team-member h5 {
            margin-top: 10px;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .team-member p {
            color: #777;
            font-size: 1rem;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">DocNest</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="Hospital.php">Hospitals</a></li>
                <li class="nav-item"><a class="nav-link" href="Pharmacy.php">Pharmacy</a></li>
                <li class="nav-item"><a class="nav-link" href="appointment.php">Appointments</a></li>
                <li class="nav-item"><a class="nav-link" href="order.php">Order</a></li>
            </ul>
            <div class="auth-buttons ms-3">
                <a href="login.php">Login</a>
                <a href="#" class="ms-2">Sign Up</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero">
    <div class="overlay"></div>
    <div class="z-index-1">
        <h1>Welcome to DocNest</h1>
        <p>Your Smart Healthcare Partner</p>
    </div>
</div>

<!-- About Section -->
<div class="container my-5">
    <h2 class="section-title">Who We Are</h2>
    <p class="section-text">
        DocNest is an advanced healthcare platform designed to connect patients with top doctors effortlessly.  
        Our goal is to enhance medical accessibility with easy appointment booking, real-time availability tracking, pharmacy availability,  
        and seamless digital health solutions.
    </p>
</div>

<!-- Mission Section -->
<div class="container my-5">
    <h2 class="section-title">Our Mission</h2>
    <div class="row text-center">
        <div class="col-md-4">
            <h4>🚀 Innovation</h4>
            <p>Bringing cutting-edge AI into healthcare, making doctor appointments smarter and seamless.</p>
        </div>
        <div class="col-md-4">
            <h4>❤ Patient First</h4>
            <p>We ensure comfort with hassle-free bookings, secure consultations, and instant medical reports.</p>
        </div>
        <div class="col-md-4">
            <h4>🌍 Accessibility</h4>
            <p>Connecting patients and doctors with an easy-to-use platform that works for everyone.</p>
        </div>
    </div>
</div>

<!-- Team Section -->
<div class="container my-5">
    <h2 class="section-title">Meet Our Team</h2>
    <div class="row justify-content-center">
        <?php
            $team = [
                ["name" => "Dr. Aadhithiyan ", "role" => "Founder & CEO", "img" => "Aadhithiyan CEO.jpg"],
                ["name" => "Dr.Preethi", "role" => "CTO & AI Expert", "img" => "Dr.Preethi.jpg"],
                ["name" => "Tamil", "role" => "Lead Developer", "img" => "Tamil.jpg"]
            ];
            foreach ($team as $member) {
                echo '
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="images/'.$member['img'].'" alt="'.$member['name'].'" class="team-img">
                        <h5>'.$member['name'].'</h5>
                        <p>'.$member['role'].'</p>
                    </div>
                </div>';
            }
        ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>