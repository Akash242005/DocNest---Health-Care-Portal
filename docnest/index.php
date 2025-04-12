
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Docnest</title>
  <link rel="icon" href="images/doclogo.jpeg" />
  <link rel="stylesheet" href="style.css" />
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
        }

        .navbar {
            position: fixed;
            width: 100%;
            height: 70px;
            background: rgba(0, 97, 253, 0.85); /* Semi-transparent blue */
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            backdrop-filter: blur(5px); /* Adds a slight blur effect */
        }

        .navbar .logo {
            display: flex;
            align-items: center;
        }

        .navbar img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .navbar h1 {
            color: white;
            font-size: 22px;
            font-weight: bold;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .navbar ul li {
            display: inline;
        }

        .navbar ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .navbar ul li a:hover {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }

        .navbar .login-btn {
            background: white;
            color: #0061fd;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
            text-decoration: none;
        }

        .navbar .login-btn:hover {
            background: #004db3;
            color: white;
        }
  </style>
</head>

<body>
  <div class="navbar">
    <img src="images/logo1.jpg" alt="docnest.logo" />
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="Hospital.php">Hospitals</a>
    <a href="Pharmacy.php">Pharmacy</a>
    <a href="appointment.php">Appointments</a>
    <a href="order.php">Order</a>
    <a href="admin.php">Admin</a>
    <div class="auth-buttons">
      <a href="login.php" class="login-btn">Login</a>
      <a href="#" class="signup-btn">Sign Up</a>
    </div>
    <!-- <a href="#" class="log" id="in">Log in</a>
      <a href="#" class="sign">Sign in</a> -->
    <!-- <a href="#" class="book">Book Appoinment</a> -->
  </div>
  <div class="container">
    <img src="images/medi.jpg" alt="quotes" id="quo" />
    <h3 class="quote">"Where care comes first"</h3>
  </div>
  <div class="carousel-container">
    <div class="carousel">
      <div class="carousel-card"><img src="images/doc1.jpeg" alt="Doctor 1"></div>
      <div class="carousel-card"><img src="images/doc2.jpeg" alt="Doctor 2"></div>
      <div class="carousel-card"><img src="images/doc3.jpeg" alt="Doctor 3"></div>
      <div class="carousel-card"><img src="images/doc4.jpg" alt="Doctor 4"></div>
    </div>
  </div>
  <div class="footer-section social">
    <h2>Follow Us</h2>
    <a href="www.facebook.com"><i class="fa fa-facebook">Facebook</i></a><br>
    <a href="#"><i class="fa fa-twitter">Twitter</i></a><br>
    <a href="#"><i class="fa fa-instagram">Instagram</i></a><br>
    <a href="#"><i class="fa fa-linkedin">Linked In</i></a>
  </div>

  <div class="footer-bottom">
    <p>&copy; 2025 HealthConnect | All Rights Reserved</p>
  </div>
  </footer>

  <script>
    const carousel = document.querySelector(".carousel");
    const cards = document.querySelectorAll(".carousel-card");

    let index = 0;

    function updateCarousel() {
      carousel.style.transform = `translateX(-${index * 100}%)`;
    }

    nextBtn.addEventListener("click", () => {
      index = (index + 1) % cards.length;
      updateCarousel();
    });

    prevBtn.addEventListener("click", () => {
      index = (index - 1 + cards.length) % cards.length;
      updateCarousel();
    });
  </script>
</body>

</html>
