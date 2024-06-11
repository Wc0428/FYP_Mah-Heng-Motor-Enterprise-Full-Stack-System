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
        $sql = "SELECT component.Component_Name, SUM(ordered_component.Ordered_Component_Quantity) AS Total_Quantity, SUM(ordered_component.Ordered_Component_Quantity * ordered_component.Ordered_Component_Price) AS Price
                FROM ordered_component 
                INNER JOIN invoice_details ON ordered_component.Invoice_ID = invoice_details.Invoice_ID
                INNER JOIN component ON ordered_component.Component_ID = component.Component_ID
                WHERE invoice_details.Invoice_Date BETWEEN '$start_date' AND '$end_date'
                GROUP BY component.Component_Name";

        // Execute the query
        $result = $conn->query($sql);

        if ($result) {
          if ($result->num_rows > 0) {
            $overallTotalPrice = 0;
            $componentData = [];
            // Output data as a table
            echo '<div class="big-box">';
            echo '<div class="company-info">'; // Company info div
            echo '<p><h1>Invoices Report</h1></p>';
            echo '<p><h3>Mah Heng Motor Enterprise</h3></p>';
            echo '<p>63, Jalan Sri Skudai, Taman Sri Skudai, 81300 Skudai, Johor.</p>';
            echo '<p>+60162866926</p>';
            echo '</div>'; // End company info div
            echo '<div class="date-box">';
            echo 'Selected Date Range :';
            echo "<h4>Start Date : $start_date</h4>";
            echo "<h4>End Date &nbsp; : $end_date</h4>";
            echo '</div>';
            echo '<table>';
            echo '<tr><th>Name</th><th>Quantity</th><th>Price (RM)</th></tr>';
            while($row = $result->fetch_assoc()) {
              $componentTotalPrice = $row['Price'];
              $overallTotalPrice += $componentTotalPrice;
              $formattedPrice = number_format($componentTotalPrice, 2);
              echo "<tr><td>{$row['Component_Name']}</td><td>{$row['Total_Quantity']}</td><td>{$row['Price']}</td></tr>";
              // Collect data for chart
              $componentData[] = $row;
            }
            $formattedOverallPrice = number_format($overallTotalPrice, 2);
            echo "<tr><td colspan='2'><strong>Overall Total Outcome (RM)</strong></td><td><strong>{$formattedOverallPrice}</strong></td></tr>";
            echo '</table>';
            echo '</div>';
            // Output chart data as JSON
            echo '<script>';
            echo 'var componentData = ' . json_encode($componentData) . ';';
            echo '</script>';
          } else {
            echo "<p>There are no invoices on these dates.....</p>";
          }
        } else {
            echo "Error executing the query: " . $conn->error;
        }
    } else {
        echo "<p>Please select valid date!</p>";
    }
}

// Close connection
$conn->close();
?>
<style>
    .big-box {
        border: 1px solid #ccc;
        padding: 20px;
        margin: 20px;
    }

    .date-box {
        padding: 10px;
        line-height: 0.3; 
    }

    .company-info {
        text-align: center;
        line-height: 0.5; 
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    /* Set the size of the canvas for the pie chart */
    #componentChart {
        max-width: 800px; /* Adjust the width as needed */
        max-height: 800px; /* Adjust the height as needed */
        margin: 100 ;
        margin-left:300px;
    }
</style>
<canvas id="componentChart"></canvas>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof componentData !== 'undefined' && componentData.length > 0) {
            var ctx = document.getElementById('componentChart').getContext('2d');
            var labels = componentData.map(function(item) { return item.Component_Name; });
            var quantities = componentData.map(function(item) { return item.Total_Quantity; });
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Quantity',
                        data: quantities,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
