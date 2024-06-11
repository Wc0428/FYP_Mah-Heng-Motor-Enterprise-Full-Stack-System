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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invoiceId = $_POST['invoiceId'];
    $invoiceDate = $_POST['invoiceDate'];
    $totalPrice = $_POST['totalPrice'];
    // Add more fields as needed

    if ($invoiceId) {
        // Update existing invoice
        $sql = "UPDATE invoice_details SET Invoice_Date=?, Invoice_Total_Price=? WHERE Invoice_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdi", $invoiceDate, $totalPrice, $invoiceId);
    } else {
        // Insert new invoice
        $sql = "INSERT INTO invoice_details (Invoice_Date, Invoice_Total_Price) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sd", $invoiceDate, $totalPrice);
    }

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
