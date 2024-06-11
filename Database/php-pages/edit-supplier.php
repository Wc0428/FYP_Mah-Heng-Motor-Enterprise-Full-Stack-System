<?php
header('Content-Type: application/json');

// Replace with your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "mah heng motor database";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Check if the required POST variables are set
if (!isset($_POST['supplierId']) || !isset($_POST['supplierName']) || !isset($_POST['supplierContact'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
    exit;
}

// Get the POST variables
$supplierId = $_POST['supplierId'];
$supplierName = $_POST['supplierName'];
$supplierContact = $_POST['supplierContact'];

// Prepare and bind
$stmt = $conn->prepare("UPDATE supplier_details SET Supplier_Name = ?, Supplier_Contact_Number = ? WHERE Supplier_ID = ?");
$stmt->bind_param("ssi", $supplierName, $supplierContact, $supplierId);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Supplier details updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating supplier details: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
