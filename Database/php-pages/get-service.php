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
$serviceId = intval($_GET['id']); // Assuming 'id' is an integer

// Prepare and execute SQL query
$sql = "SELECT service.*,customer_details.*,service_component.*, component.*
        FROM service 
        INNER JOIN customer_details ON customer_details.Customer_ID = service.Customer_ID 
        INNER JOIN service_component ON service_component.Service_ID = service.Service_ID 
        INNER JOIN component ON component.Component_ID = service_component.Component_ID
        WHERE service.Service_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $serviceId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $response = array(); // Initialize the response array
    $count = 0;

    // Loop through each row in the result set
    while ($row = $result->fetch_assoc()) {
        // Add each row to the response array
        $response["row$count"] = array(
            'serviceId' => $row['Service_ID'],
            'description' => $row['Description'],
            'totalPrice' => $row['Service_Total_Price'],
            'serviceDate' => $row['Service_Date'],
            'motorcycleId' => $row['Motor_ID'],
            'customerPhone' => $row['Customer_Contact_Number'],
            // Add other fields as needed
            'componentId' => $row['Component_ID'],
            'componentName' => $row['Component_Name'],
            'customerId' => $row['Customer_ID'],
            'customerName' => $row['Customer_Name'],
            'serviceComponentPricePerUnit' => $row['Service_Component_Price_Per_Unit'],
            'serviceComponentQuantity' => $row['Service_Component_Quantity']
        );
        $count = $count + 1; // Increment count
    }

    // Encode the response array as JSON and echo it
    echo json_encode($response);
} else {
    echo json_encode(array('error' => 'Service not found'));
}

// Close prepared statement and database connection
$stmt->close();
$conn->close();
?>
