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
        // Close the statement and the connection
        $stmt->close();
        $conn->close();

        // Display alert message using JavaScript
        echo '<script type="text/javascript">';
        echo 'alert("Your application has been submitted!");';
        echo 'window.location.href = "' . $_SERVER['REQUEST_URI'] . '";'; // Redirect after showing alert
        echo '</script>';
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="images/logo.png" type="image/png">
    <title>MAH HENG MOTOR ENTERPRISE BOOKING WEBSITE</title>
</head>
<body>

<header>
    <img src="images/logo.png" id="logo">
    <nav>
        <a href="#main">Main</a>
        <a href="#profile">Profile</a>
        <a href="#booking">Appointment</a>
        <a href="#about">About</a>
        <button id="menu">
            <span></span>
            <span></span>
        </button>
    </nav>
</header>

<div id="container">
    <section id="main" style="background-image: url(images/1.jpg);">
        <div class="text1">
            <p style="text-align: left; color: #ffffff; font-family: 'Poetsen One', sans-serif, cursive; font-size: 24px; font-weight: 400; line-height: 1.5; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);">Welcome To</p>
            <h1>MAH HENG</h1>
            <h1>MOTOR</h1>
            <h1>ENTERPRISE</h1>
            <p style="text-align: left; color: #ffffff; font-family: 'Poetsen One', sans-serif, cursive; font-size: 24px; font-weight: 400; line-height: 1.5; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);">Your trusted partner in motor repairs and services.</p>
        </div>
    </section>
    <section id="profile" style="background-image: url(images/2.jpg);">
        <div class="wrapper">
            <span class="first-text">We are a</span>
            <span class="shop-name">Motorcycle Repair Shop</span>
            <span class="services-header">Services We Offer:</span>
            <ul class="sec-texts">
                <li><span>Engine Repair</span></li>
                <li><span>Brake Maintenance</span></li>
                <li><span>Suspension Tuning</span></li>
                <li><span>Tire Replacement</span></li>
            </ul>
        </div>
    </section>
    <section id="booking" style="background-image: url(images/3.jpg);">
        <div class="container-form">
            <form id="mainForm" action="" method="POST" novalidate>
                <h2>APPOINTMENT</h2>
                <div class="form-control">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" autocomplete="off">
                    <i class="icon"></i>
                </div>

                <div class="form-control">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" autocomplete="off">
                    <i class="icon"></i>
                </div>

                <div class="form-control">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone" autocomplete="off">
                    <i class="icon"></i>
                </div>

                <div class="form-control">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required><br><br>
                    <i class="icon" style="top: 58%;"></i>
                </div>

                <div class="form-control">
                    <label for="time" name="time">Time:</label>
                    <select id="time" name="time" required>
                        <!-- Time options will be populated using JavaScript -->
                    </select><br><br>
                </div>

                <div class="form-control">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Enter your message"></textarea>
                    <i class="icon"></i>
                </div>

                <button type="submit" id="submitBtn">Submit</button>

            </form>
        </div>

        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2 style="color: black;">Success!</h2>
                <p style="color: black;">Your appointment has been submitted successfully.</p>
            </div>
        </div>
    </section>
    <section id="about" style="background-image: url(images/4.jpg);">

        <div class="about-content">
            <h1 style="    text-align: center; size: 40px;">About</h1>
            <p>Shop Name : MAH HENG MOTOR ENTERPRISE </p>
            <p>Phone Number : <a href="tel:+60162866926" style="color: #ffffff;">+60162866926</a></p>
            <p>Location : 63, Jalan Sri Skudai, Taman Sri Skudai, 81300, Johor</p>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.5464661917134!2d103.67041691533835!3d1.5254033612565547!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da6dfc91234567%3A0xfed1234567890abc!2s63%2C%20Jalan%20Sri%20Skudai%2C%20Taman%20Sri%20Skudai%2C%2081300%20Johor!5e0!3m2!1sen!2smy!4v1599491434114!5m2!1sen!2smy"
                width="500"
                height="350"
                style="border:0;"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </section>
</div>

<script src="script.js"></script>
</body>
</html>
