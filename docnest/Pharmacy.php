<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "docnest";

// Simulate a logged-in user for testing (replace with real login logic)
$_SESSION['user_name'] = "John Doe"; // Remove or adjust in a real system

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all pharmacies
$sql = "SELECT * FROM pharmacies";
$pharmacies_result = $conn->query($sql);
$pharmacies = [];
while ($row = $pharmacies_result->fetch_assoc()) {
    $pharmacies[] = $row;
}

// Fetch all medicines
$sql = "SELECT p.*, ph.name AS pharmacy_name FROM pharmacy p JOIN pharmacies ph ON p.pharmacy_id = ph.id";
$medicines_result = $conn->query($sql);
$medicine_list = [];
while ($row = $medicines_result->fetch_assoc()) {
    $medicine_list[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Tab</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            text-align: center;
            position: relative;
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

        .search-container {
            margin: 90px auto 20px;
            width: 50%;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-bar {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .cart-button {
            padding: 10px 20px;
            background: #0061fd;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .cart-button:hover {
            background: #004db3;
        }

        .pharmacy-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
            padding: 20px;
        }

        .pharmacy-card {
            background: #e0f7e9;
            padding: 15px;
            border-radius: 5px;
            text-align: left;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .pharmacy-card:hover {
            background: #d0f0e0;
        }

        .pharmacy-card img {
            width: 100px;
            height: 100px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        #result-text {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            display: none;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70%;
            max-height: 80vh;
            background: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            z-index: 2000;
            overflow-y: auto;
        }

        .popup h2 {
            margin-bottom: 15px;
            color: #0061fd;
        }

        .medicine-search {
            margin-bottom: 15px;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .medicine-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .medicine-item {
            padding: 15px;
            background: #f0f0f0;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .quantity-input {
            width: 60px;
            padding: 5px;
            margin-left: 10px;
        }

        .button {
            padding: 10px 20px;
            background: #0061fd;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }

        .button:hover {
            background: #004db3;
        }

        .remove-btn {
            padding: 5px 10px;
            background: #ff4444;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background: #cc0000;
        }

        .done-btn {
            padding: 5px 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .done-btn:hover {
            background: #218838;
        }

        .minus-btn {
            padding: 2px 8px;
            background: #ffcc00;
            color: black;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-left: 5px;
        }

        .minus-btn:hover {
            background: #e6b800;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1500;
        }

        .cart-popup, .receipt {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            max-height: 80vh;
            background: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            z-index: 2000;
            overflow-y: auto;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .cart-table th, .cart-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .cart-table th {
            background: #f0f0f0;
        }

        .message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border-radius: 5px;
            z-index: 2500;
            display: none;
        }

        .error-message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #ff4444;
            color: white;
            border-radius: 5px;
            z-index: 2500;
            display: none;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="nav-left">
            <div class="logo">
                <img src="images/logo1.jpg" alt="docnest.logo" />
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="Hospital.php">Hospitals</a></li>
                <li><a href="Pharmacy.php">Pharmacy</a></li>
                <li><a href="appointment.php">Appointments</a></li>
                <li><a href="order.php">Order</a></li>
            </ul>
        </div>
        <div class="auth-buttons">
            <a href="login.php" class="login-btn">Login</a>
            <a href="#" class="signup-btn">Sign Up</a>
        </div>
    </div>

    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Search for pharmacy..." onkeyup="searchFunction()">
        <button class="cart-button" onclick="showCart()">Cart</button>
    </div>

    <div id="result-text">Here are the pharmacies that match your search</div>

    <!-- Pharmacy List -->
    <div class="pharmacy-container" id="pharmacyContainer">
        <?php
        if (!empty($pharmacies)) {
            foreach ($pharmacies as $pharmacy) {
                echo '<div class="pharmacy-card" onclick="showMedicines(' . $pharmacy['id'] . ', \'' . htmlspecialchars($pharmacy['name']) . '\')">';
                echo '<img src="https://via.placeholder.com/100" alt="Pharmacy">';
                echo '<div class="pharmacy-details">';
                echo '<strong>' . htmlspecialchars($pharmacy['name']) . '</strong><br>';
                echo 'Location: ' . htmlspecialchars($pharmacy['location']) . '<br>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No pharmacies found in the database.</p>';
        }
        ?>
    </div>

    <!-- Popup for Medicines -->
    <div class="popup" id="medicinePopup">
        <h2 id="popupTitle"></h2>
        <input type="text" class="medicine-search" id="medicineSearch" placeholder="Search medicines..." onkeyup="filterMedicines()">
        <div class="medicine-list" id="medicineList"></div>
        <button class="button" onclick="closePopup()">Back</button>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="closePopup()"></div>

    <!-- Cart Popup -->
    <div class="cart-popup" id="cartPopup">
        <h2>Shopping Cart</h2>
        <table class="cart-table" id="cartTable">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Pharmacy</th>
                    <th>Price/Unit</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cartItems"></tbody>
        </table>
        <p>Total: $<span id="cartTotal">0</span></p>
        <button class="button" onclick="placeOrder()">Place Order</button>
        <button class="button" onclick="closeCart()">Close</button>
    </div>

    <!-- Receipt -->
    <div class="receipt" id="receipt">
        <h2>Order Receipt</h2>
        <table class="cart-table" id="receiptTable">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Pharmacy</th>
                    <th>Price/Unit</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="receiptItems"></tbody>
        </table>
        <p>Total: $<span id="receiptTotal">0</span></p>
        <button class="button" onclick="downloadReceiptAsPDF()">Download</button>
        <button class="button" onclick="closeReceipt()">Close</button>
    </div>

    <!-- Message -->
    <div class="message" id="cartMessage"></div>
    <div class="error-message" id="errorMessage"></div>

    <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        const { jsPDF } = window.jspdf;
        let cart = [];
        const medicines = <?php echo json_encode($medicine_list); ?>;
        let currentPharmacyId;

        function searchFunction() {
            var input, filter, cards, text, i, visible = false;
            input = document.querySelector(".search-bar");
            filter = input.value.toUpperCase();
            cards = document.querySelectorAll(".pharmacy-card");
            
            for (i = 0; i < cards.length; i++) {
                text = cards[i].textContent || cards[i].innerText;
                if (text.toUpperCase().indexOf(filter) > -1) {
                    cards[i].style.display = "flex";
                    visible = true;
                } else {
                    cards[i].style.display = "none";
                }
            }
            
            document.getElementById("result-text").style.display = visible ? "block" : "none";
        }

        function showMedicines(pharmacyId, pharmacyName) {
            currentPharmacyId = pharmacyId;
            const popup = document.getElementById("medicinePopup");
            const overlay = document.getElementById("overlay");
            const medicineList = document.getElementById("medicineList");
            document.getElementById("popupTitle").textContent = pharmacyName + " - Medicines";
            document.getElementById("medicineSearch").value = "";
            medicineList.innerHTML = "";

            const pharmacyMedicines = medicines.filter(m => m.pharmacy_id == pharmacyId);
            renderMedicines(pharmacyMedicines);

            popup.style.display = "block";
            overlay.style.display = "block";
        }

        function renderMedicines(pharmacyMedicines) {
            const medicineList = document.getElementById("medicineList");
            medicineList.innerHTML = "";
            if (pharmacyMedicines.length > 0) {
                pharmacyMedicines.forEach(medicine => {
                    const item = document.createElement("div");
                    item.className = "medicine-item";
                    item.innerHTML = `
                        <div>
                            <strong>${medicine.name}</strong><br>
                            Total Quantity: ${medicine.stock_quantity}<br>
                            Price per Unit: $${medicine.price}
                        </div>
                        <div>
                            <label>Qty to Buy: <input type="number" class="quantity-input" id="qty-${medicine.id}" min="1" max="${medicine.stock_quantity}" value="1" onchange="calculateAmount(${medicine.id}, ${medicine.price}, this.value)"></label><br>
                            <span>Total: $<span id="amount-${medicine.id}">${medicine.price}</span></span><br>
                            <button class="button" onclick="addToCart(${medicine.id}, '${medicine.name}', ${medicine.price}, document.getElementById('qty-${medicine.id}').value, '${medicine.pharmacy_name}')">Add to Cart</button>
                        </div>
                    `;
                    medicineList.appendChild(item);
                });
            } else {
                medicineList.textContent = "No medicines available.";
            }
        }

        function filterMedicines() {
            const filter = document.getElementById("medicineSearch").value.toUpperCase();
            const pharmacyMedicines = medicines.filter(m => m.pharmacy_id == currentPharmacyId);
            const filteredMedicines = pharmacyMedicines.filter(m => m.name.toUpperCase().includes(filter));
            renderMedicines(filteredMedicines);
        }

        function calculateAmount(medicineId, price, quantity) {
            const amount = price * quantity;
            document.getElementById(`amount-${medicineId}`).textContent = amount.toFixed(2);
        }

        function addToCart(medicineId, name, price, quantity, pharmacyName) {
            const requestedQty = parseInt(quantity);
            if (isNaN(requestedQty) || requestedQty <= 0) {
                showErrorMessage("Please enter a valid quantity.");
                return;
            }

            const medicine = medicines.find(m => m.id == medicineId && m.pharmacy_name === pharmacyName);
            if (!medicine) {
                showErrorMessage("Medicine not found.");
                return;
            }

            const stockQty = parseInt(medicine.stock_quantity);
            const existingItem = cart.find(item => item.id == medicineId && item.pharmacyName === pharmacyName);
            const currentQtyInCart = existingItem ? existingItem.quantity : 0;
            const totalRequestedQty = currentQtyInCart + requestedQty;

            if (totalRequestedQty > stockQty) {
                showErrorMessage(`Cannot add ${requestedQty} of ${name}. Only ${stockQty} available, and you already have ${currentQtyInCart} in your cart.`);
                return;
            }

            if (existingItem) {
                existingItem.quantity = totalRequestedQty;
            } else {
                cart.push({ id: medicineId, name, price, quantity: requestedQty, pharmacyName });
            }
            showMessage(`${name} added to cart!`);
        }

        function showMessage(text) {
            const message = document.getElementById("cartMessage");
            message.textContent = text;
            message.style.display = "block";
            setTimeout(() => message.style.display = "none", 2000);
        }

        function showErrorMessage(text) {
            const errorMessage = document.getElementById("errorMessage");
            errorMessage.textContent = text;
            errorMessage.style.display = "block";
            setTimeout(() => errorMessage.style.display = "none", 3000);
        }

        function showCart() {
            const cartPopup = document.getElementById("cartPopup");
            const overlay = document.getElementById("overlay");
            const cartItems = document.getElementById("cartItems");
            const cartTotal = document.getElementById("cartTotal");
            cartItems.innerHTML = "";
            let total = 0;

            if (cart.length > 0) {
                cart.forEach((item, index) => {
                    const amount = item.price * item.quantity;
                    total += amount;
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>${item.pharmacyName}</td>
                        <td>$${item.price}</td>
                        <td id="quantity-${index}">${item.quantity}</td>
                        <td id="subtotal-${index}">$${amount.toFixed(2)}</td>
                        <td><button class="remove-btn" id="remove-${index}" onclick="toggleRemove(${index})">Remove</button></td>
                    `;
                    cartItems.appendChild(row);
                });
            } else {
                cartItems.innerHTML = '<tr><td colspan="6">Cart is empty.</td></tr>';
            }

            cartTotal.textContent = total.toFixed(2);
            cartPopup.style.display = "block";
            overlay.style.display = "block";
        }

        function toggleRemove(index) {
            const removeBtn = document.getElementById(`remove-${index}`);
            const quantityCell = document.getElementById(`quantity-${index}`);

            if (removeBtn.textContent === "Remove") {
                removeBtn.textContent = "Done";
                removeBtn.className = "done-btn";
                quantityCell.innerHTML = `
                    ${cart[index].quantity} 
                    <button class="minus-btn" onclick="decreaseQuantity(${index})">-</button>
                `;
            } else {
                removeBtn.textContent = "Remove";
                removeBtn.className = "remove-btn";
                quantityCell.textContent = cart[index].quantity;
            }
        }

        function decreaseQuantity(index) {
            if (cart[index].quantity > 1) {
                cart[index].quantity--;
                const amount = cart[index].price * cart[index].quantity;
                document.getElementById(`quantity-${index}`).innerHTML = `
                    ${cart[index].quantity} 
                    <button class="minus-btn" onclick="decreaseQuantity(${index})">-</button>
                `;
                document.getElementById(`subtotal-${index}`).textContent = `$${amount.toFixed(2)}`;
                updateCartTotal();
            } else {
                cart.splice(index, 1);
                showCart();
            }
        }

        function updateCartTotal() {
            let total = 0;
            cart.forEach(item => total += item.price * item.quantity);
            document.getElementById("cartTotal").textContent = total.toFixed(2);
        }

        function placeOrder() {
            if (cart.length === 0) {
                alert("Cart is empty!");
                return;
            }

            fetch('save_order.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ cart: cart })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const receipt = document.getElementById("receipt");
                    const receiptItems = document.getElementById("receiptItems");
                    const receiptTotal = document.getElementById("receiptTotal");
                    receiptItems.innerHTML = "";
                    let total = 0;

                    cart.forEach(item => {
                        const amount = item.price * item.quantity;
                        total += amount;
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${item.name}</td>
                            <td>${item.pharmacyName}</td>
                            <td>$${item.price}</td>
                            <td>${item.quantity}</td>
                            <td>$${amount.toFixed(2)}</td>
                        `;
                        receiptItems.appendChild(row);
                    });

                    receiptTotal.textContent = total.toFixed(2);
                    document.getElementById("cartPopup").style.display = "none";
                    receipt.style.display = "block";
                    showMessage("Order placed successfully! Order ID: " + data.order_id);
                } else {
                    showErrorMessage(data.error || "Failed to place order.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorMessage("An error occurred while placing the order.");
            });
        }

        function downloadReceiptAsPDF() {
            const doc = new jsPDF();
            let y = 10;

            doc.setFontSize(16);
            doc.text("Order Receipt", 10, y);
            y += 10;

            doc.setFontSize(12);
            doc.text("Medicine", 10, y);
            doc.text("Pharmacy", 50, y);
            doc.text("Price/Unit", 90, y);
            doc.text("Quantity", 130, y);
            doc.text("Subtotal", 170, y);
            y += 5;
            doc.line(10, y, 190, y);
            y += 5;

            cart.forEach(item => {
                const amount = item.price * item.quantity;
                doc.text(item.name, 10, y);
                doc.text(item.pharmacyName, 50, y);
                doc.text(`$${item.price}`, 90, y);
                doc.text(`${item.quantity}`, 130, y);
                doc.text(`$${amount.toFixed(2)}`, 170, y);
                y += 10;
            });

            y += 5;
            doc.line(10, y, 190, y);
            y += 5;
            doc.text(`Total: $${document.getElementById("receiptTotal").textContent}`, 10, y);

            doc.save("order_receipt.pdf");
        }

        function closePopup() {
            document.getElementById("medicinePopup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

        function closeCart() {
            document.getElementById("cartPopup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

        function closeReceipt() {
            document.getElementById("receipt").style.display = "none";
            document.getElementById("overlay").style.display = "none";
            cart = [];
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>