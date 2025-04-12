<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "docnest";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if ID is provided
if (isset($_GET["id"])) {
    $hosid = intval($_GET["id"]); // Ensure it's an integer to prevent SQL injection

    // Fetch hospital name using the hospital ID
    $sql = "SELECT hosname FROM hospital WHERE id = $hosid";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hosname = $row["hosname"];

        // Fetch doctors including available_time (fix: changed 'available_time' to 'time')
        $hosname_safe = $conn->real_escape_string($hosname);
        $sql = "SELECT docname, speciality, tokens, time FROM doctor WHERE hosname = '$hosname_safe'";
        $result = $conn->query($sql);

        $doctors = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $doctors[] = [
                    "docname" => $row["docname"],
                    "specialty" => $row["speciality"],
                    "tokens" => $row["tokens"],
                    "available_time" => $row["time"] // Fix: using correct column name
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($doctors, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(["error" => "No doctors available for this hospital."]);
        }
    } else {
        echo json_encode(["error" => "Invalid hospital ID."]);
    }
} else {
    echo json_encode(["error" => "Invalid hospital selection."]);
}

$conn->close();
?>
