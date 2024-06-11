<?php
// Include your database connection file
include_once 'db_connection.php';

// Check if service ID is provided
if (isset($_GET['serviceId'])) {
    $serviceId = $_GET['serviceId'];

    // Prepare SQL statement to fetch service data
    $sql = "SELECT * FROM services WHERE service_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $serviceId);

    // Execute SQL statement
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Fetch service data
    $serviceData = $result->fetch_assoc();

    // Return service data as JSON
    echo json_encode($serviceData);
} else {
    // Service ID not provided, handle error
    echo "Service ID not provided";
}

// Close database connection
$stmt->close();
$conn->close();
?>
