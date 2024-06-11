<?php
// Include your database connection file
include_once 'db_connection.php';

// Check if service ID is provided
if (isset($_GET['invoiceId'])) {
    $serviceId = $_GET['invoiceId'];

    // Prepare SQL statement to fetch service data
    $sql = "SELECT * FROM invoice_details WHERE invoice_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $serviceId);

    // Execute SQL statement
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Fetch service data
    $invoiceData = $result->fetch_assoc();

    // Return service data as JSON
    echo json_encode($invoiceData);
} else {
    // Service ID not provided, handle error
    echo "Invoice ID not provided";
}

// Close database connection
$stmt->close();
$conn->close();
?>
