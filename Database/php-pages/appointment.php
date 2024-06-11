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

// Fetch appointments data in descending order by date and time
$sql = "SELECT id, name, email, phone, date, time, message, viewed FROM appointments ORDER BY date DESC, time DESC";
$result = $conn->query($sql);

// Add this code at the beginning to handle the mark as viewed request
if (isset($_POST['toggle_viewed'])) {
    $appointmentId = $_POST['appointment_id'];
    // Fetch the current viewed status from the database
    $sql = "SELECT viewed FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();
    $stmt->bind_result($viewed);
    $stmt->fetch();
    $stmt->close();

    // Toggle the viewed status
    $viewed = $viewed ? 0 : 1;

    // Update the viewed status in the database
    $updateSql = "UPDATE appointments SET viewed = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ii", $viewed, $appointmentId);
    $stmt->execute();
    $stmt->close();
    
    // Redirect back to the same page
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

?>
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_appointment'])) {
    // Retrieve and sanitize appointment ID
    $appointment_id = $conn->real_escape_string($_POST["appointment_id"]);

    // Prepare and execute the DELETE SQL statement
    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);

    if ($stmt->execute()) {
        echo '<script type="text/javascript">';
        echo ' alert("Appointment deleted successfully!")';
        echo '</script>';
    } else {
        echo "Error deleting appointment: " . $stmt->error;
    }
    header("Location: appointment.php");
    exit();
    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../stylesheets/style1.css">
    <link rel="icon" href="../image/logo.png" type="image/png">
    <title>Mah Heng Motor Appointments</title>
</head>
<style>
        /* Styling for the search container */
        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
            margin-left:60px;
        }

        .search-container input[type="text"],
        .search-container input[type="date"] {
            width: 58%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: all 0.3s ease;
       
  
        }

        .search-container input[type="text"]:focus,
        .search-container input[type="date"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        /* Additional styling to ensure both inputs align well */
        .search-container input[type="text"]::placeholder,
        .search-container input[type="date"]::placeholder {
            color: #999;
        }

        .search-container input[type="text"] {
            margin-right: 2%;
        }

        .search-container input[type="date"] {
            margin-left: 2%;
        }

        /* Styling for rows that have been viewed */
        .viewed {
            background-color: #d1e7ff; /* Light blue background */
        }

        /* Styling for the mark-viewed button */
        .mark-viewed {
            background-color: #007bff; /* Blue background color */
            color: white;
            padding: 10px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .mark-viewed:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        table th:nth-child(1), table td:nth-child(1) { width: 5%; }
        table th:nth-child(2), table td:nth-child(2) { width: 15%; }
        table th:nth-child(3), table td:nth-child(3) { width: 20%; }
        table th:nth-child(4), table td:nth-child(4) { width: 10%; }
        table th:nth-child(5), table td:nth-child(5) { width: 10%; }
        table th:nth-child(6), table td:nth-child(6) { width: 10%; }
        table th:nth-child(7), table td:nth-child(7) { width: 20%; }
        table th:nth-child(8), table td:nth-child(8) { width: 10%; }
    </style>
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
                <a href="#" onclick="window.location.href = 'dashboard.php'">
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
                
                <a href="#" onclick="window.location.href = 'appointment.php'" class="active" >
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
            <h1>Appointment</h1>
            <div class="content">
             <div class="search-container">
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names...&#128270;">
        <input type="date" id="dateInput" onchange="searchTable()">
    </div>
    <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Date</th>
            <th>Time</th>
            <th>Message</th>
            <th colspan="2" class="actions">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            $currentDate = '';
            $dateGroupClass = 'date-group-odd';
            while($row = $result->fetch_assoc()) {
                if ($row["date"] != $currentDate) {
                    $currentDate = $row["date"];
                    $dateGroupClass = ($dateGroupClass == 'date-group-odd') ? 'date-group-even' : 'date-group-odd';
                }
                $viewedClass = $row["viewed"] ? 'viewed' : '';
                echo "<tr class='{$dateGroupClass} {$viewedClass}'>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["date"] . "</td>";
                echo "<td>" . $row["time"] . "</td>";
                echo "<td>" . $row["message"] . "</td>";
                echo "<td> <form method='POST' style='display:inline-block;'>
            <input type='hidden' name='appointment_id' value='" . $row["id"] . "'>
            <button type='submit' name='toggle_viewed' class='mark-viewed " . ($row['viewed'] ? 'viewed' : '') . "'>
                <span class='material-icons'>" . ($row['viewed'] ? 'visibility' : 'visibility_off') . "</span>
            </button>
        </form></td>";
        echo "<td>
        <form method='POST' style='display:inline-block;' onsubmit='return confirmDelete()'>
            <input type='hidden' name='appointment_id' value='" . $row["id"] . "'>
            <button type='submit' name='delete_appointment' class='delete-button'>
                <span class='material-icons'>delete</span> <!-- Display delete icon -->
            </button>
        </form>
      </td>";
      echo "<script>
      // Find the row in the table and remove it
      var rowToDelete = document.querySelector('tr[data-id=\"" . $row["id"] . "\"]');
      if (rowToDelete) {
          rowToDelete.remove();
      }
    </script>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No appointments found</td></tr>";
        }
        ?>
             <tbody>
    </table>
</div>
</div>
</main>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this appointment?");
    }


function searchTable() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let dateInput = document.getElementById("dateInput").value;
    let table = document.querySelector("table");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName("td");
        let nameMatch = false;
        let dateMatch = false;

        // Loop through each column in the row
        for (let j = 0; j < td.length; j++) {
            let cellValue = td[j].innerHTML.toLowerCase();

            // Check if the current column is the "Name" column (index 1)
            if (j === 1) {
                if (cellValue.indexOf(input) > -1) {
                    nameMatch = true;
                }
            }

            // Assuming the date is in the 5th column (index 4)
            if (j === 4 && dateInput) {
                let cellDate = td[j].innerHTML;
                if (cellDate === dateInput) {
                    dateMatch = true;
                }
            }
        }

        // Show or hide the row based on search criteria
        if ((!input && !dateInput) || (nameMatch && !dateInput) || (!input && dateMatch) || (nameMatch && dateMatch)) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

</script>



  </body>

</html>