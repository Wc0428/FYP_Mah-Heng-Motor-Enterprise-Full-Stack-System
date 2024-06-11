<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
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
    $invoiceTotalPrice = $_POST["totalPrice"];
    $invoiceDate = $_POST["invoiceDate"]; 
    $invoiceComponents = $_POST["invoiceComponents"];
    $supplierType = $_POST["supplierType"];
    
    // Determine if we are editing an existing invoice
    $isEdit = isset($_POST["invoiceID"]) && !empty($_POST["invoiceID"]);
    $invoiceID = $isEdit ? $_POST["invoiceID"] : null;

    if ($supplierType == "existing"){
        //Get Supplier ID from Dropdownbox
        $supplierID = $_POST["supplierID"];
    }
    else if ($supplierType == "new"){
        $supplierName = $_POST["supplierName"];
        $supplierPhone = preg_replace('/\s+/', '', $_POST["supplierPhone"]);
        
        // Check if a supplier with the same name and phone number already exists
        $checkDuplicateQuery = "SELECT * FROM supplier_details WHERE Supplier_Name='$supplierName' AND Supplier_Contact_Number='$supplierPhone'";
        $duplicateResult = $conn->query($checkDuplicateQuery);

        if ($duplicateResult->num_rows > 0) {
            echo "<script>alert('Error: Supplier with the same name and phone number already exists!'); window.history.back();</script>";
            exit();
        }
        
        // Insert new supplier details
        $supplierQuery = "INSERT INTO supplier_details (Supplier_Name, Supplier_Contact_Number) VALUES ('$supplierName', '$supplierPhone');";
        $conn->query($supplierQuery);
        //Get Supplier ID from insert query
        $supplierID = $conn->insert_id;
    }
    else {
        echo "Invalid supplier option selected.";
        exit();
    }

    if ($isEdit) {
        // Retrieve and restore old component quantities
        $getOldComponentsQuery = "SELECT Component_ID, Ordered_Component_Quantity FROM ordered_component WHERE Invoice_ID='$invoiceID';";
        $oldComponentsResult = $conn->query($getOldComponentsQuery);
        
        while ($oldComponent = $oldComponentsResult->fetch_assoc()) {
            $oldComponentID = $oldComponent['Component_ID'];
            $oldComponentQuantity = $oldComponent['Ordered_Component_Quantity'];
            $restoreStockQuery = "UPDATE component SET Component_Quantity = Component_Quantity - $oldComponentQuantity WHERE Component_ID = $oldComponentID";
            $conn->query($restoreStockQuery);
        }
        
        // Update existing invoice details
        $invoiceQuery = "UPDATE invoice_details SET Invoice_Total_Price='$invoiceTotalPrice', Invoice_Date='$invoiceDate', Supplier_ID='$supplierID' WHERE Invoice_ID='$invoiceID';";
        if ($conn->query($invoiceQuery) === TRUE) {
            // Remove old ordered components
            $deleteComponentsQuery = "DELETE FROM ordered_component WHERE Invoice_ID='$invoiceID';";
            $conn->query($deleteComponentsQuery);
        }
    } else {
        // Insert new invoice details
        $invoiceQuery = "INSERT INTO invoice_details (Invoice_Total_Price, Invoice_Date, Supplier_ID) VALUES ('$invoiceTotalPrice', '$invoiceDate', '$supplierID');";
        if ($conn->query($invoiceQuery) === TRUE) {
            $invoiceID = $conn->insert_id;
        } else {
            echo "Error: " . $invoiceQuery . "<br>" . $conn->error;
            exit();
        }
    }

    // Insert ordered components
    foreach($invoiceComponents as $component){
        $componentID = $component["existingComponentName"];
        $componentPricePerPiece = $component["pricePerPiece"];
        $componentQuantity = $component["quantity"];
        if ($componentID == "new"){
            $componentName = $component["newComponentName"];
            //Insert new component details
            $newComponentQuery = "INSERT INTO component (Component_Name, Component_Quantity) VALUES ('$componentName', 0);";
            $conn->query($newComponentQuery);
            $componentID = $conn->insert_id;
        }
        $invoiceComponentQuery = "INSERT INTO ordered_component (Invoice_ID, Component_ID, Ordered_Component_Price, Ordered_Component_Quantity) VALUES ($invoiceID, $componentID, $componentPricePerPiece, $componentQuantity);";
        if ($conn->query($invoiceComponentQuery) === TRUE){
            $updateStockQuery = "UPDATE component SET Component_Quantity = Component_Quantity + $componentQuantity WHERE Component_ID = $componentID";
            $conn->query($updateStockQuery);
        } else {
            echo "Error: " . $invoiceComponentQuery . "<br>" . $conn->error;
            exit();
        }
    }

    $conn->close();
    header("Location: ../invoices.php");
    exit();
}
?>
