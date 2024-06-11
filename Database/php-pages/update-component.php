<?php
// update-component.php

$servername = "localhost";
$username = "root";
$password = "";
$database = "mah heng motor database";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $componentId = $_POST['componentId'];
    $componentName = $_POST['componentName'];

    $sql = "UPDATE component SET Component_Name = ? WHERE Component_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $componentName, $componentId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Component name updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update component name"]);
    }

    $stmt->close();
}

$conn->close();
?>
