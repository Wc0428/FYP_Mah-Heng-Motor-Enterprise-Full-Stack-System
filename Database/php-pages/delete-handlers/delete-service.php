<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['serviceId'])) {
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

    $serviceId = $_POST['serviceId'];

    // Start a transaction
    $conn->begin_transaction();

    // Fetch components related to the service
    $getComponentsQuery = "SELECT Component_ID, Service_Component_Quantity FROM service_component WHERE Service_ID = $serviceId";
    $componentsResult = $conn->query($getComponentsQuery);
    if ($componentsResult->num_rows > 0) {
        while ($componentRow = $componentsResult->fetch_assoc()) {
            $componentId = $componentRow['Component_ID'];
            $quantity = $componentRow['Service_Component_Quantity'];

            // Update component quantity in stock
            $updateStockQuery = "UPDATE component SET Component_Quantity = Component_Quantity + $quantity WHERE Component_ID = $componentId";
            if (!$conn->query($updateStockQuery)) {
                // Rollback transaction and exit if update fails
                $conn->rollback();
                die(json_encode(array('success' => false, 'message' => 'Error updating stock: ' . $conn->error)));
            }
        }
    }

    // Delete service components related to this service
    $deleteServiceComponentsQuery = "DELETE FROM service_component WHERE Service_ID = $serviceId";
    if ($conn->query($deleteServiceComponentsQuery) === TRUE) {
        // Delete the service record
        $deleteServiceQuery = "DELETE FROM service WHERE Service_ID = $serviceId";
        if ($conn->query($deleteServiceQuery) === TRUE) {
            // Commit the transaction if all queries succeed
            $conn->commit();
            echo json_encode(array('success' => true, 'message' => 'Service deleted successfully!'));
        } else {
            // Rollback the transaction if service deletion fails
            $conn->rollback();
            die(json_encode(array('success' => false, 'message' => 'Error deleting service record: ' . $conn->error)));
        }
    } else {
        // Rollback the transaction if service components deletion fails
        $conn->rollback();
        die(json_encode(array('success' => false, 'message' => 'Error deleting service components: ' . $conn->error)));
    }

    // Close the connection
    $conn->close();
} else {
    die(json_encode(array('success' => false, 'message' => 'Invalid request!')));
}
?>
