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
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize user input for security
$invoiceId = intval($_GET['id']); 


// Prepare and execute SQL query
$sql = "SELECT invoice_details.*, supplier_details.*, ordered_component.*, component.*
        FROM invoice_details
        INNER JOIN supplier_details ON supplier_details.Supplier_ID = invoice_details.Supplier_ID
        INNER JOIN ordered_component ON ordered_component.Invoice_ID = invoice_details.Invoice_ID
        INNER JOIN component ON component.Component_ID = ordered_component.Component_ID
        WHERE invoice_details.Invoice_ID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $invoiceId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $response = array(); // Initialize the response array
 $count = 0;
    // Loop through each row in the result set
    while ($row = $result->fetch_assoc()) {
        // Add each row to the response array
        $response["row$count"] = array(
            'invoiceId' => $row['Invoice_ID'],
            'totalPrice' => $row['Invoice_Total_Price'],
            'invoiceDate' => $row['Invoice_Date'],
            'supplierId' => $row['Supplier_ID'],
            'supplierName' => $row['Supplier_Name'],
            'supplierPhone' => $row['Supplier_Contact_Number'],
            'componentId' => $row['Component_ID'],
            'componentName' => $row['Component_Name'],
            'orderedComponentPrice' => $row['Ordered_Component_Price'],
            'orderedComponentQuantity' => $row['Ordered_Component_Quantity']
        );
        $count = $count + 1; // Increment count
    }

    // Encode the response array as JSON and echo it
    echo json_encode($response);
} else {
    echo json_encode(array('error' => 'Invoice not found'));
}

// Close prepared statement and database connection
$stmt->close();
$conn->close();
?>
