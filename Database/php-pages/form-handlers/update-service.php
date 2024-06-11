<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    
    // Retrieve form data
    $serviceID = $_POST["serviceID"]; // Assuming you have a hidden input field in your form to capture serviceID
    $serviceDescription = $_POST["description"];
    $serviceTotalPrice = $_POST["totalPrice"];
    $serviceDate = $_POST["serviceDate"];
    $serviceMotorID = $_POST["motorcycleId"];
    $serviceComponents = $_POST["serviceComponents"];

    // Get Customer ID based on if the customer is existing or new
    $customerType = $_POST["customerType"];
    if ($customerType == "existing") {
        $customerID = $_POST["customerID"];
    } elseif ($customerType == "new") {
        $customerName = $_POST["customerName"];
        $customerPhone = preg_replace('/\s+/', '', $_POST["customerPhone"]);

        // Check if a supplier with the same name and phone number already exists
        $checkDuplicateQuery = "SELECT * FROM customer_details WHERE Customer_Name='$customerName' AND Customer_Contact_Number='$customerPhone'";
        $duplicateResult = $conn->query($checkDuplicateQuery);
        if ($duplicateResult->num_rows > 0) {
            // Duplicate customer found
            echo "Error: Customer with the same name and phone number already exists.";
            exit();
        }

        // Insert new customer details
        $customerQuery = "INSERT INTO customer_details (Customer_Name, Customer_Contact_Number) VALUES ('$customerName', '$customerPhone');";
        if ($conn->query($customerQuery) === TRUE) {
            $customerID = $conn->insert_id;
            echo "<script>console.log('PHP Message: " . $customerID . "');</script>";

        } else {
            echo "Error creating new customer: " . $conn->error;
            exit();
        }
    } else {
        // Invalid customer option selected
        echo "Invalid customer option selected.";
        exit();
    }
    echo "<script>console.log('PHP Message: " . $serviceID . "');</script>";
   
    // Up date service details
    $updateServiceQuery = "UPDATE service SET Description='$serviceDescription', Service_Total_Price='$serviceTotalPrice', Service_Date='$serviceDate', Motor_ID='$serviceMotorID' , Customer_ID='$customerID'  WHERE Service_ID='$serviceID'";

    if ($conn->query($updateServiceQuery) === TRUE) {

        // Retrieve component IDs and quantities associated with the service
        $selectServiceComponentsQuery = "SELECT Component_ID, Service_Component_Quantity FROM service_component WHERE Service_ID='$serviceID'";
        $serviceComponentsResult = $conn->query($selectServiceComponentsQuery);

        // Check if there are any service components
        if ($serviceComponentsResult->num_rows > 0) {
            // Array to store component IDs and quantities
            $componentData = array();

            // Fetch component IDs and quantities and store them in the array
            while ($row = $serviceComponentsResult->fetch_assoc()) {
                $componentID = $row["Component_ID"];
                $componentQuantity = $row["Service_Component_Quantity"];
                $componentData[] = array("componentID" => $componentID, "quantity" => $componentQuantity);
            }

            // Delete service components
            $deleteServiceComponentsQuery = "DELETE FROM service_component WHERE Service_ID='$serviceID'";
            $conn->query($deleteServiceComponentsQuery);

            // Update component quantities in the component table
            foreach ($componentData as $component) {
                $componentID = $component["componentID"];
                $quantity = $component["quantity"];

                // Increment component quantity in the component table
                $updateComponentQuantityQuery = "UPDATE component SET Component_Quantity = Component_Quantity + $quantity WHERE Component_ID = $componentID";
                $conn->query($updateComponentQuantityQuery);
            }
        }
        // Insert updated service components
        foreach ($serviceComponents as $component) {
            $componentID = $component["componentName"];
            $componentPricePerPiece = $component["pricePerPiece"];
            $componentQuantity = $component["quantity"];
            $insertServiceComponentQuery = "INSERT INTO service_component (Service_ID, Component_ID, Service_Component_Price_Per_Unit, Service_Component_Quantity) VALUES ('$serviceID','$componentID','$componentPricePerPiece','$componentQuantity')";
            if ($conn->query($insertServiceComponentQuery) === FALSE) {
                echo "Error inserting service component: " . $conn->error;
                exit();
            }

            
            // Update stock quantity
            $deductStockQuery = "UPDATE component SET Component_Quantity = Component_Quantity - '$componentQuantity' WHERE Component_ID = '$componentID'";
            if ($conn->query($deductStockQuery) === FALSE) {
                echo "Error updating component stock: " . $conn->error;
                exit();
            }
        }

        header("Location: ../services.php");
        exit();
    } else {
        echo "Error updating service: " . $conn->error;
        exit();
    }

    $conn->close();
}
?>
