<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "mah heng motor database";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch unread appointments
$sql = "SELECT id, name, date, time FROM appointments WHERE viewed = 0 ORDER BY date DESC, time DESC";
$result = $conn->query($sql);

$appointments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the appointments in JSON format
header('Content-Type: application/json');
echo json_encode($appointments);
?>
