<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoiceId'])) {
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

    $invoiceId = $_POST['invoiceId'];

    // Start a transaction
    $conn->begin_transaction();

    // Fetch components related to the invoice
    $getComponentsQuery = "SELECT Component_ID, Ordered_Component_Quantity FROM ordered_component WHERE Invoice_ID = $invoiceId";
    $componentsResult = $conn->query($getComponentsQuery);
    if ($componentsResult->num_rows > 0) {
        while ($componentRow = $componentsResult->fetch_assoc()) {
            $componentId = $componentRow['Component_ID'];
            $quantity = $componentRow['Ordered_Component_Quantity'];

            // Update component quantity in stock
            $updateStockQuery = "UPDATE component SET Component_Quantity = Component_Quantity - $quantity WHERE Component_ID = $componentId";
            if (!$conn->query($updateStockQuery)) {
                // Rollback transaction and exit if update fails
                $conn->rollback();
                die(json_encode(array('success' => false, 'message' => 'Error updating stock: ' . $conn->error)));
            }
        }
    }

    // Delete ordered components related to this invoice
    $deleteOrderedComponentsQuery = "DELETE FROM ordered_component WHERE Invoice_ID = $invoiceId";
    if ($conn->query($deleteOrderedComponentsQuery) === TRUE) {
        // Delete the invoice record
        $deleteInvoiceQuery = "DELETE FROM invoice_details WHERE Invoice_ID = $invoiceId";
        if ($conn->query($deleteInvoiceQuery) === TRUE) {
            // Commit the transaction if all queries succeed
            $conn->commit();
            echo json_encode(array('success' => true, 'message' => 'Invoice deleted successfully!'));
        } else {
            // Rollback the transaction if invoice deletion fails
            $conn->rollback();
            die(json_encode(array('success' => false, 'message' => 'Error deleting invoice record: ' . $conn->error)));
        }
    } else {
        // Rollback the transaction if ordered components deletion fails
        $conn->rollback();
        die(json_encode(array('success' => false, 'message' => 'Error deleting ordered components: ' . $conn->error)));
    }

    // Close the connection
    $conn->close();
} else {
    die(json_encode(array('success' => false, 'message' => 'Invalid request!')));
}
?>
