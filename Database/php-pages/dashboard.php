<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../stylesheets/style1.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="../image/logo.png" type="image/png">
    <title>Mah Heng Motor Dashboard</title>
    <style>


        .date-time {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            background-color: #f0f0f0;
            padding: 10px 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .date {
            margin-right: 10px;
        }

        .time {
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="../image/logo.png">
                    <h2>Mah<span class="danger">HENG</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="#" onclick="window.location.href = 'dashboard.php'"class="active" >
                    <span class="material-icons-sharp" >
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                  
                </a>
                <a href="#" onclick="window.location.href = 'services.php'" >
                    <span class="material-icons-sharp">
                        inventory
                    </span>
                    <h3>Sales</h3>
                </a>
                <a href="#" onclick="window.location.href = 'invoices.php'" >
                    <span class="material-symbols-outlined">
                        request_quote
                        </span>
                    <h3>Invoices</h3>
                </a>
                <a href="#" onclick="window.location.href = 'customers.php'">
                    <span class="material-icons-sharp">
                        person
                    </span>
                    <h3>Customers</h3>
                </a>
                <a href="#" onclick="window.location.href = 'suppliers.php'">
                    <span class="material-symbols-outlined">
                        partner_exchange
                        </span>
                    <h3>Suppliers</h3>
                </a>
                
                <a href="#" onclick="window.location.href = 'stock.php'">
                    <span class="material-icons-sharp">
                        inventory_2
                    </span>
                    <h3>Stock</h3>

                </a>

                <a href="#" onclick="window.location.href = 'report.php'">
                    <span class="material-icons-sharp">
                        menu_book
                    </span>
                    <h3>Reports</h3>
                </a>

                <a href="#" onclick="window.location.href = 'appointment.php'" >
                    <span class="material-icons-sharp">
                calendar_month
                </span>
                    <h3>Appointment</h3>
                 
                </a>

                <a href="#" onclick="window.location.href = '../index.html'">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Dashboard</h1>
            <!-- Analyses -->
            <div class="analyse">
                <div class="sales">
                    <div class="status">
                        <div class="info">
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

                            // Calculate the start and end dates for the current month
                            $current_start_date = date('Y-m-01'); // First day of the current month
                            $current_end_date = date('Y-m-t'); // Last day of the current month

                            // Calculate the start and end dates for the previous month
                            $previous_start_date = date('Y-m-01', strtotime('-1 month', strtotime($current_start_date)));
                            $previous_end_date = date('Y-m-t', strtotime('-1 month', strtotime($current_start_date)));

                            // Function to get total sales for a given date range
                            function getTotalSales($conn, $start_date, $end_date) {
                                $sql = "SELECT SUM(service_component.Service_Component_Quantity * service_component.Service_Component_Price_Per_Unit) AS Total_Price
                                        FROM service_component 
                                        INNER JOIN service ON service_component.Service_ID = service.Service_ID
                                        WHERE service.Service_Date BETWEEN '$start_date' AND '$end_date'";
                                $result = $conn->query($sql);
                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    return $row['Total_Price'] ? $row['Total_Price'] : 0;
                                } else {
                                    return 0;
                                }
                            }

                            // Get total sales for the current month
                            $current_total_sales = getTotalSales($conn, $current_start_date, $current_end_date);

                            // Get total sales for the previous month
                            $previous_total_sales = getTotalSales($conn, $previous_start_date, $previous_end_date);

                            // Calculate the percentage change
                            if ($previous_total_sales > 0) {
                                $percentage_change = (($current_total_sales - $previous_total_sales) / $previous_total_sales) * 100;
                            } else {
                                $percentage_change = $current_total_sales > 0 ? 100 : 0; // Handle division by zero
                            }
                            
                            
                            // Format the percentage change
                            if ($percentage_change > 0) {
                                $percentage_change_formatted = "+" . number_format($percentage_change, 2);
                            } else {
                                $percentage_change_formatted = number_format($percentage_change, 2);
                            }

                            $current_month = date('F');

                            echo '<style>
                                .month-name {
                                    font-size: 16px; /* Adjust the font size as needed */
                                    color: #3498db; /* Change the color to your preference */
                                    font-weight: bold; /* Make the text bold */
                                    background-color: #f0f8ff; /* Light blue background color */
                                    padding: 5px 10px; /* Add some padding */
                                    border-radius: 5px; /* Round the corners */
                                    display: inline-block; /* Ensure it fits the content */
                                }
                            </style>';
                            // Output total sales for the current month
                            $formattedCurrentTotalSales = number_format($current_total_sales, 2);
                            echo "<h2>Total Sales -> <span class='month-name'>$current_month</span></h2>";
                            echo '<h1 style="margin-bottom: 0px";>RM ' . $formattedCurrentTotalSales . '</h1>';

                            // Output percentage change
                            echo '<div class="progresss">';
                            echo '<svg>';
                            echo '<circle cx="100" cy="45" r="38"></circle>';
                            echo '</svg>';
                            echo '<div class="percentage">';
                            echo "<p>{$percentage_change_formatted}%</p>";
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';


                            // Close connection
                            $conn->close();
                            ?>
                            
                            <div class="visits">
                            <div class="status">
                            <div class="info">
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

                            // Calculate the start and end dates for the current month
                            $current_start_date = date('Y-m-01'); // First day of the current month
                            $current_end_date = date('Y-m-t'); // Last day of the current month

                            // Calculate the start and end dates for the previous month
                            $previous_start_date = date('Y-m-01', strtotime('-1 month', strtotime($current_start_date)));
                            $previous_end_date = date('Y-m-t', strtotime('-1 month', strtotime($current_start_date)));

                            // Function to get total sales for a given date range
                            function getTotalInvoices($conn, $start_date, $end_date) {
                                $sql = "SELECT SUM(ordered_component.Ordered_Component_Quantity * ordered_component.Ordered_Component_Price) AS Price
                                        FROM ordered_component 
                                        INNER JOIN invoice_details ON ordered_component.Invoice_ID = invoice_details.Invoice_ID
                                        INNER JOIN component ON ordered_component.Component_ID = component.Component_ID
                                        WHERE invoice_details.Invoice_Date BETWEEN '$start_date' AND '$end_date'";
                                $result = $conn->query($sql);
                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    return $row['Price'] ? $row['Price'] : 0;
                                } else {
                                    return 0;
                                }
                            }

                            // Get total sales for the current month
                            $current_total_invoices = getTotalInvoices($conn, $current_start_date, $current_end_date);

                            // Get total sales for the previous month
                            $previous_total_invoices = getTotalInvoices($conn, $previous_start_date, $previous_end_date);

                            // Calculate the percentage change
                            if ($previous_total_invoices > 0) {
                                $percentage_change = (($current_total_invoices - $previous_total_invoices) / $previous_total_invoices) * 100;
                            } else {
                                $percentage_change = $current_total_invoices > 0 ? 100 : 0; // Handle division by zero
                            }
                            
                            
                            // Format the percentage change
                            if ($percentage_change > 0) {
                                $percentage_change_formatted = "+" . number_format($percentage_change, 2);
                            } else {
                                $percentage_change_formatted = number_format($percentage_change, 2);
                            }

                            $current_month = date('F');

                            echo '<style>
                                .month-name {
                                    font-size: 16px; /* Adjust the font size as needed */
                                    color: #3498db; /* Change the color to your preference */
                                    font-weight: bold; /* Make the text bold */
                                    background-color: #f0f8ff; /* Light blue background color */
                                    padding: 5px 10px; /* Add some padding */
                                    border-radius: 5px; /* Round the corners */
                                    display: inline-block; /* Ensure it fits the content */
                                }
                            </style>';
                            // Output total sales for the current month
                            $formattedCurrentTotalInvoices = number_format($current_total_invoices, 2);
                            echo "<h2>Total Invoices -> <span class='month-name'>$current_month</span></h2>";
                            echo '<h1 style="margin-bottom: 0px; margin-top: 5px;">RM ' . $formattedCurrentTotalInvoices . '</h1>';

                            // Output percentage change
                            echo '<div class="progresss">';
                            echo '<svg>';
                            echo '<circle cx="100" cy="45" r="38"></circle>';
                            echo '</svg>';
                            echo '<div class="percentage">';
                            echo "<p>{$percentage_change_formatted}%</p>";
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';


                            // Close connection
                            $conn->close();
                            ?>   
                        <div class="searches">
                            <div class="status">
                                <div class="info">
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

                        // Calculate the start and end dates for the current month
                        $current_start_date = date('Y-m-01'); // First day of the current month
                        $current_end_date = date('Y-m-t'); // Last day of the current month

                        // Calculate the start and end dates for the previous month
                        $previous_start_date = date('Y-m-01', strtotime('-1 month', strtotime($current_start_date)));
                        $previous_end_date = date('Y-m-t', strtotime('-1 month', strtotime($current_start_date)));

                        // Function to get total sales for a given date range
                        function getTotalSaless($conn, $start_date, $end_date) {
                            $sql = "SELECT SUM(service_component.Service_Component_Quantity * service_component.Service_Component_Price_Per_Unit) AS Total_Price
                                    FROM service_component 
                                    INNER JOIN service ON service_component.Service_ID = service.Service_ID
                                    WHERE service.Service_Date BETWEEN '$start_date' AND '$end_date'";
                            $result = $conn->query($sql);
                            if ($result) {
                                $row = $result->fetch_assoc();
                                return $row['Total_Price'] ? $row['Total_Price'] : 0;
                            } else {
                                return 0;
                            }
                        }

                        // Function to get total invoices for a given date range
                        function getTotalInvoicess($conn, $start_date, $end_date) {
                            $sql = "SELECT SUM(ordered_component.Ordered_Component_Quantity * ordered_component.Ordered_Component_Price) AS Total_Price
                                    FROM ordered_component 
                                    INNER JOIN invoice_details ON ordered_component.Invoice_ID = invoice_details.Invoice_ID
                                    WHERE invoice_details.Invoice_Date BETWEEN '$start_date' AND '$end_date'";
                            $result = $conn->query($sql);
                            if ($result) {
                                $row = $result->fetch_assoc();
                                return $row['Total_Price'] ? $row['Total_Price'] : 0;
                            } else {
                                return 0;
                            }
                                                }
                        // Get total sales for the current month
                        $current_total_sales = getTotalSaless($conn, $current_start_date, $current_end_date);

                        // Get total invoices for the current month
                        $current_total_invoices = getTotalInvoicess($conn, $current_start_date, $current_end_date);

                        // Calculate the total revenue for the current month
                        $current_total_revenue = $current_total_sales - $current_total_invoices;

                        // Get total sales for the previous month
                        $previous_total_sales = getTotalSaless($conn, $previous_start_date, $previous_end_date);

                        // Get total invoices for the previous month
                        $previous_total_invoices = getTotalInvoicess($conn, $previous_start_date, $previous_end_date);

                        // Calculate the total revenue for the previous month
                        $previous_total_revenue = $previous_total_sales - $previous_total_invoices;

                        // Calculate the absolute percentage change in revenue
                        if ($previous_total_revenue != 0) {
                            $percentage_change = (($current_total_revenue - $previous_total_revenue) / abs($previous_total_revenue)) * 100;
                        } else {
                            $percentage_change = $current_total_revenue > 0 ? 100 : 0; // Handle division by zero
                        }

                        // Format the percentage change
                        $percentage_change_formatted = ($percentage_change >= 0) ? "+" . number_format($percentage_change, 2) : number_format($percentage_change, 2);

                        // Get the current month name
                        $current_month = date('F');

                        // Output the styled month name
                        echo '<style>
                            .month-name {
                                font-size: 24px; /* Adjust the font size as needed */
                                color: #3498db; /* Change the color to your preference */
                                font-weight: bold; /* Make the text bold */
                                background-color: #f0f8ff; /* Light blue background color */
                                padding: 5px 10px; /* Add some padding */
                                border-radius: 5px; /* Round the corners */
                                display: inline-block; /* Ensure it fits the content */
                            }
                        </style>';

                        // Output total revenue for the current month
                        $formattedTotalRevenue = number_format($current_total_revenue, 2);
                        echo "<h2 >Total Revenue -> <span class='month-name'>$current_month</span></h2>";
                        echo '<h1 style="margin-bottom: 0px; margin-top: 5px;">RM ' . $formattedTotalRevenue . '</h1>';

                        // Output percentage change
                        echo '<div class="progresss">';
                            echo '<svg>';
                            echo '<circle cx="100" cy="45" r="38"></circle>';
                            echo '</svg>';
                            echo '<div class="percentage">';
                            echo "<p>{$percentage_change_formatted}%</p>";
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';


                        // Close connection
                        $conn->close();
                        ?>
</div>      
<div class="new-users">
                <h2>Sales and Invoices Over the Past Year</h2>
                <div class="user-list">
            <!-- End of Analyses -->
            <canvas id="salesInvoicesChart" width="800" height="400"></canvas>            <!-- New Users Section -->

                    
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

                // Get current date
                $current_date = date('Y-m-d');
                $current_year = date('Y', strtotime($current_date));
                $current_month = date('n', strtotime($current_date));

                // Calculate the start and end dates for the previous year
                $previous_start_date = ($current_year - 1) . "-06-01"; // June 1st of the previous year
                $previous_end_date = ($current_year - 1) . "-" . $current_month . "-" . date('t', strtotime($current_date)); // Last day of the current month of the previous year

                // Function to get total sales for a given date range
                function getsTotalSales($conn, $start_date, $end_date) {
                    $sql = "SELECT SUM(service_component.Service_Component_Quantity * service_component.Service_Component_Price_Per_Unit) AS Total_Sales
                            FROM service_component 
                            LEFT JOIN service ON service_component.Service_ID = service.Service_ID
                            WHERE service.Service_Date BETWEEN '$start_date' AND '$end_date'";
                    $result = $conn->query($sql);
                    if ($result) {
                        $row = $result->fetch_assoc();
                        return $row['Total_Sales'] ? $row['Total_Sales'] : 0;
                    } else {
                        return 0;
                    }
                }

                // Function to get total invoices for a given date range
                function getsTotalInvoices($conn, $start_date, $end_date) {
                    $sql = "SELECT SUM(ordered_component.Ordered_Component_Quantity * ordered_component.Ordered_Component_Price) AS Total_Invoices
                            FROM ordered_component 
                            INNER JOIN invoice_details ON ordered_component.Invoice_ID = invoice_details.Invoice_ID
                            WHERE invoice_details.Invoice_Date BETWEEN '$start_date' AND '$end_date'";
                    $result = $conn->query($sql);
                    if ($result) {
                        $row = $result->fetch_assoc();
                        return $row['Total_Invoices'] ? $row['Total_Invoices'] : 0;
                    } else {
                        return 0;
                    }
                }

                // Arrays to store data for the line chart
                $sales_data = array();
                $invoices_data = array();

                // Loop through each month of the previous year and get total sales and invoices
                for ($month = 6; $month <= 12; $month++) {
                    $start_date = ($current_year - 1) . "-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01"; // First day of the month
                    $end_date = ($current_year - 1) . "-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . date('t', strtotime($start_date)); // Last day of the month
                    $total_sales = getsTotalSales($conn, $start_date, $end_date);
                    $total_invoices = getsTotalInvoices($conn, $start_date, $end_date);
                    $sales_data[date('M Y', strtotime($start_date))] = $total_sales;
                    $invoices_data[date('M Y', strtotime($start_date))] = $total_invoices;
                }

                for ($month = 1; $month <= $current_month; $month++) {
                    $start_date = $current_year . "-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01"; // First day of the month
                    $end_date = $current_year . "-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . date('t', strtotime($start_date)); // Last day of the month
                    $total_sales = getsTotalSales($conn, $start_date, $end_date);
                    $total_invoices = getsTotalInvoices($conn, $start_date, $end_date);
                    $sales_data[date('M Y', strtotime($start_date))] = $total_sales;
                    $invoices_data[date('M Y', strtotime($start_date))] = $total_invoices;
                }

                // Close connection
                $conn->close();
            ?>

                                
                 
                </div>
            </div>
            <!-- End of New Users Section -->
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>
            </div>
            <!-- End of Nav -->
            <?php
            date_default_timezone_set('Asia/Kuala_Lumpur'); // Set the time zone to Malaysia

            $current_date = date('F j, Y');
            $current_time = date('h:i A');
            ?>

            <div class="user-profile">
            <div class="date-time">
          <span class="date"><?php echo $current_date; ?></span>
        <span class="time"><?php echo $current_time; ?></span>
    </div>
            </div>
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_as_read'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $update_sql = "UPDATE appointments SET viewed = TRUE WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $stmt->close();
}

// Retrieve unread appointments from the database
$sql = "SELECT id, name, date, time FROM appointments WHERE viewed = FALSE ORDER BY date, time";
$result = $conn->query($sql);

$appointments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

$conn->close();
?>

<div class="reminders">
        <div class="header">
            <h2>Appointment Notifications</h2>
            <?php if (count($appointments) > 0): ?>
                <span class="notification-icon">
                    <span class="material-icons-sharp">
                        notifications
                    </span>
                    <span class="unread-count"><?= count($appointments) ?></span>
                </span>
            <?php else: ?>
                <span class="notification-icon">
                    <span class="material-icons-sharp">
                        notifications_none
                    </span>
                </span>
            <?php endif; ?>
        </div>

        <?php if (empty($appointments)): ?>
            <p>No new booking notifications.</p>
        <?php else: ?>
            <?php foreach ($appointments as $appointment): ?>
                <div class="notification">
                    <div class="icon">
                        <span class="material-icons-sharp">event_available</span>
                    </div>
                    <div class="content">
                        <div class="info">
                            <h3>New Booking Appointment</h3>
                            <small class="text-muted"><?= htmlspecialchars($appointment['name']) ?> - <?= htmlspecialchars($appointment['date']) ?> <?= htmlspecialchars($appointment['time']) ?></small>
                        </div>
                        <a href="appointment.php">
                        <span class="material-icons-sharp">arrow_forward</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

            </div>
        </div>
    </div>

    <script src="orders.js"></script>
    <script src="../scripts/index.js"></script>
    <script>
        // Retrieve PHP data for the chart
        var salesData = <?php echo json_encode($sales_data); ?>;
        var invoicesData = <?php echo json_encode($invoices_data); ?>;
        
        // Prepare data for Chart.js
        var labels = Object.keys(salesData);
        var salesValues = Object.values(salesData);
        var invoicesValues = Object.values(invoicesData);
        
        // Create Chart.js line chart
        var ctx = document.getElementById('salesInvoicesChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sales',
                    data: salesValues,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                },
                {
                    label: 'Total Invoices',
                    data: invoicesValues,
                    fill: false,
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>