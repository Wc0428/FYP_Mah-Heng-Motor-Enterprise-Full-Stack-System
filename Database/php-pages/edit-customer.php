<?php
// Replace with your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "mah heng motor database";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Retrieve POST data
$customerId = $_POST['customerId'];
$customerName = $_POST['customerName'];
$customerContact = $_POST['customerContact'];

// Update customer details in the database
$sql = "UPDATE customer_details SET Customer_Name = ?, Customer_Contact_Number = ? WHERE Customer_ID = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die(json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]));
}

$stmt->bind_param("ssi", $customerName, $customerContact, $customerId);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Customer updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating customer: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
