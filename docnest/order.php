<?php
session_start();
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "John Doe";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Docnest - My Orders</title>
  <link rel="icon" href="images/doclogo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
      min-height: 100vh;
      color: #333;
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
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 57px;
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

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 60px;
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

        .navbar .auth-buttons {
            display: flex;
            gap: 10px;
        }

        .navbar .signup-btn {
            color: white;
            padding: 8px 15px;
            text-decoration: none;
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

    .container {
      max-width: 1000px;
      margin: 50px auto;
      padding: 0 15px;
    }

    h1 {
      color: #2c3e50;
      margin-bottom: 20px;
      font-size: 28px;
      font-weight: 600;
    }

    .filters {
      margin-bottom: 20px;
    }

    .filters button {
      padding: 8px 16px;
      margin-right: 10px;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .filters button:hover {
      background-color: #2980b9;
    }

    .filters button.active {
      background-color: #2ecc71;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #3498db;
      color: white;
      font-weight: 600;
    }

    tr:hover {
      background-color: #f9f9f9;
    }

    .action-btn {
      padding: 6px 12px;
      background-color: #2ecc71;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .action-btn:hover {
      background-color: #27ae60;
    }

    .hidden {
      display: none;
    }
    .footer { 
      margin-top: 20px; 
      text-align: center; 
      color: #7f8c8d; 
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="index.php">DocNest</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="Hospital.php">Hospitals</a></li>
          <li class="nav-item"><a class="nav-link" href="Pharmacy.php">Pharmacy</a></li>
          <li class="nav-item"><a class="nav-link" href="appointment.php">Appointments</a></li>
          <li class="nav-item"><a class="nav-link active" href="order.php">Order</a></li>
        </ul>
      </div>
    </div>
  </nav>
<br>
<br>
  <div class="container">
    <h1>My Orders - <?php echo htmlspecialchars($user_name); ?></h1>
    <div class="filters">
      <button class="filter-btn" data-filter="last30">Last 30 Days</button>
      <button class="filter-btn active" data-filter="all">All Orders</button>
      <button class="filter-btn" data-filter="completed">Completed</button>
      <button class="filter-btn" data-filter="pending">Pending</button>
    </div>
    <table id="ordersTable">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Date</th>
          <th>Description</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="ordersBody"></tbody>
    </table>
  </div>

  <!-- Bootstrap Modal for Details -->
  <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modalBody"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    const ordersBody = document.getElementById('ordersBody');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const modal = new bootstrap.Modal(document.getElementById('orderModal'));
    const today = new Date('2025-03-27'); // Current date for filtering
    let orders = [];

    async function fetchAndDisplayOrders() {
      try {
        const response = await fetch('api.php');
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        orders = await response.json();
        console.log('Fetched Orders:', orders);
        populateTable(orders);
      } catch (error) {
        console.error('Error:', error);
        ordersBody.innerHTML = `<tr><td colspan="5">Error: ${error.message}</td></tr>`;
      }
    }

    function populateTable(orders) {
      ordersBody.innerHTML = '';
      orders.forEach(order => {
        const row = document.createElement('tr');
        row.setAttribute('data-date', order.date);
        row.setAttribute('data-status', order.status.toLowerCase());
        row.innerHTML = `
          <td>${order.orderId}</td>
          <td>${order.date}</td>
          <td>${order.description}</td>
          <td>${order.status}</td>
          <td><button class="action-btn" data-order-id="${order.orderId}">${order.status === 'shipped' ? 'Track Order' : 'View Details'}</button></td>
        `;
        ordersBody.appendChild(row);
      });

      document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', () => {
          const orderId = button.getAttribute('data-order-id');
          const order = orders.find(o => o.orderId === orderId);
          showOrderDetails(order);
        });
      });

      filterOrders('all');
    }

    function filterOrders(filter) {
      const rows = ordersBody.querySelectorAll('tr');
      const thirtyDaysAgo = new Date(today);
      thirtyDaysAgo.setDate(today.getDate() - 30);

      rows.forEach(row => {
        const date = new Date(row.getAttribute('data-date'));
        const status = row.getAttribute('data-status');
        let show = false;

        if (filter === 'all') show = true;
        else if (filter === 'last30' && date >= thirtyDaysAgo) show = true;
        else if (filter === status) show = true;

        row.classList.toggle('hidden', !show);
      });
    }

    function showOrderDetails(order) {
      const modalBody = document.getElementById('modalBody');
      const modalLabel = document.getElementById('orderModalLabel');
      if (order.status === 'shipped') {
        modalLabel.textContent = `Tracking for Order ${order.orderId}`;
        modalBody.innerHTML = `
          <p><strong>Order ID:</strong> ${order.orderId}</p>
          <p><strong>Status:</strong> In Transit</p>
          <p><strong>Estimated Delivery:</strong> ${order.deliveryDate || 'N/A'}</p>
          <p><strong>Tracking Number:</strong> ${order.trackingNumber || 'N/A'}</p>
        `;
      } else {
        modalLabel.textContent = `Details for Order ${order.orderId}`;
        modalBody.innerHTML = `
          <p><strong>Order ID:</strong> ${order.orderId}</p>
          <p><strong>Status:</strong> ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</p>
          <p><strong>Delivery Date:</strong> ${order.deliveryDate || 'Pending'}</p>
          <p><strong>Notes:</strong> ${order.notes || 'No notes available'}</p>
        `;
      }
      modal.show();
    }

    filterButtons.forEach(button => {
      button.addEventListener('click', () => {
        filterButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        const filter = button.getAttribute('data-filter');
        filterOrders(filter);
      });
    });

    fetchAndDisplayOrders();
  </script>
  <div class="footer">
    <p>Need help? <a href="#">Contact Support</a></p>
  </div>
</body>
</html>