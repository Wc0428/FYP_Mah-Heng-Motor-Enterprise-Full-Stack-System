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

    // Retrieve and sanitize form data
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $phone = $conn->real_escape_string($_POST["phone"]);
    $date = $conn->real_escape_string($_POST["date"]);
    $time = $conn->real_escape_string($_POST["time"]);
    $message = $conn->real_escape_string($_POST["message"]);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO appointments (name, email, phone, date, time, message) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $name, $email, $phone, $date, $time, $message);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo '<script type="text/javascript">';
        echo ' alert("Your application has been submitted!")';
        echo '</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>