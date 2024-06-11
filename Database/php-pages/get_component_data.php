<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (!empty($start_date) && !empty($end_date)) {
        // Construct SQL query with date range filter and totals
        $sql = "SELECT component.Component_Name, SUM(ordered_component.Ordered_Component_Quantity) AS Total_Quantity
                FROM ordered_component 
                INNER JOIN invoice_details ON ordered_component.Invoice_ID = invoice_details.Invoice_ID
                INNER JOIN component ON ordered_component.Component_ID = component.Component_ID
                WHERE invoice_details.Invoice_Date BETWEEN '$start_date' AND '$end_date'
                GROUP BY component.Component_Name";

        // Execute the query
        $result = $conn->query($sql);

        if ($result) {
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            echo json_encode(array()); // Return empty array if no data found
        }
    } else {
        echo json_encode(array()); // Return empty array if no date selected
    }
}

// Close connection
$conn->close();
?>
