<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customerId'])) {
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

    $customerId = $_POST['customerId'];

    // Delete customer record
    $deleteCustomerQuery = "DELETE FROM customer_details WHERE Customer_ID = $customerId";
    if ($conn->query($deleteCustomerQuery) === TRUE) {
        echo json_encode(array('success' => true, 'message' => 'Customer deleted successfully!'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error deleting customer: ' . $conn->error));
    }

    // Close the connection
    $conn->close();
} else {
    die(json_encode(array('success' => false, 'message' => 'Invalid request!')));
}
?>
