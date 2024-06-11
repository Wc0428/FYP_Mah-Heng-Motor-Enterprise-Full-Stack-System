<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supplierId'])) {
    // Replace with your database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "mah heng motor database";

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die(json_encode(array('success' => false, 'message' => 'Connection failed: ' . $conn->connect_error)));
    }

    $supplierId = $_POST['supplierId'];

    // Force delete supplier record without checking other tables
    $deleteSupplierQuery = "DELETE FROM supplier_details WHERE Supplier_ID = $supplierId";
    if ($conn->query($deleteSupplierQuery) === TRUE) {
        echo json_encode(array('success' => true, 'message' => 'Supplier deleted successfully!'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error deleting supplier: ' . $conn->error));
    }

    // Close the connection
    $conn->close();
} else {
    die(json_encode(array('success' => false, 'message' => 'Invalid request!')));
}
?>
