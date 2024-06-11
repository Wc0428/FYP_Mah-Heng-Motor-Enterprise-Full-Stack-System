<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report | Mah Heng Motor Enterprise</title>
    <link rel="stylesheet" href="../stylesheets/style1.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="icon" href="../image/logo.png" type="image/png">
   <style>



.content {
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    width:200%;
    height:500px;
    max-width: 1100px;

}



form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    margin-bottom: 10px;
    font-weight: bold;
    color: #555555;
    align-self: flex-start;
}

input[type="date"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 2px solid #eeeeee;
    border-radius: 5px;
    font-size: 16px;
    color: #333333;
    background-color: #fafafa;
    transition: border-color 0.3s;
}

input[type="date"]:focus {
    border-color: #007bff;
    outline: none;
}

input[type="submit"] {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    color: #ffffff;
    background-color: #28a745;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #218838;
}

input[type="submit"]:not(:first-child) {
    background-color: #17a2b8;
}

input[type="submit"]:not(:first-child):hover {
    background-color: #138496;
}

@media (max-width: 600px) {
    .content {
        padding: 20px;
    }

    input[type="submit"] {
        margin-top: 15px;
    }
}
.button-container {
    display: flex;
    justify-content: space-between;
}

.left-button,
.right-button {
    width: 48%; /* Adjust as needed */
    padding: 20px 80px;
    margin-top:80px;
    border: none;
    border-radius: 5px;
    font-size: 20px;
    color: #ffffff;
    cursor: pointer;
    transition: background-color 0.3s;
    margin:60px; /* Add margin between the buttons */
}


.left-button {
    background-color: #17a2b8;
}

.right-button {
    background-color: #17a2b8;
}

.left-button:hover {
    background-color: #138496;
}

.right-button:hover {
    background-color: #138496;
}

@media (max-width: 600px) {
    .left-button,
    .right-button {
        width: 100%;
    }
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
                <a href="#" onclick="window.location.href = 'dashboard.php'" >
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

                <a href="#" onclick="window.location.href = 'report.php'" class="active">
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
        
    <main>
    <h1>Generate Reports</h1>
    <div class="content">
        <form method="post" action="#" id="reportForm">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date">
            <br>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date">
            <br>
            <div class="button-container">
            <input type="button" value="Generate Invoices Report" onclick="submitForm('report-handlers/report_invoice.php')" class="left-button">
            <input type="button" value="Generate Sales Report" onclick="submitForm('report-handlers/report_sales.php')" class="right-button">
        </div>
        </form>
             <!-- Chart container -->
             <canvas id="componentChart"></canvas>
    </div>
</main>
        <script type="text/javascript" src="../scripts/global-scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    </div>

    <script>

       function submitForm(action) {
    var form = document.getElementById('reportForm');
    form.setAttribute('action', action);
    form.submit(); // Submit the form
}

        // Function to fetch data and create chart
        function fetchDataAndCreateChart() {
            // Fetch data using AJAX
            $.ajax({
                url: 'get_component_data.php',
                type: 'POST',
                data: {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val()
                },
                success: function(data) {
                    // Parse JSON data
                    var jsonData = JSON.parse(data);

                    // Extract labels and data for chart
                    var componentNames = [];
                    var quantities = [];
                    for (var i = 0; i < jsonData.length; i++) {
                        componentNames.push(jsonData[i].Component_Name);
                        quantities.push(jsonData[i].Total_Quantity);
                    }

                    // Create chart using Chart.js
                    var ctx = document.getElementById('componentChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: componentNames,
                            datasets: [{
                                label: 'Quantity',
                                data: quantities,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
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
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Call fetchDataAndCreateChart function when the form is submitted
        $('#reportForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission
            fetchDataAndCreateChart(); // Call function to fetch data and create chart
        });
    </script>
</body>
</html>
