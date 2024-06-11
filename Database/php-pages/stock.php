<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock | Mah Heng Motor Enterprise</title>
    <link rel="stylesheet" href="../stylesheets/style1.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="icon" href="../image/logo.png" type="image/png">
    <style>
        
    </style>
    <script>
        function toggleSort(column) {
            var table = document.getElementById("stockTable");
            var rows = Array.from(table.getElementsByTagName("tr"));
            var headerRow = rows.shift();
            var index = Array.from(headerRow.getElementsByTagName("th")).indexOf(column);

            rows.sort(function(a, b) {
                var textA = a.cells[index].innerHTML.toLowerCase();
                var textB = b.cells[index].innerHTML.toLowerCase();
                return textA.localeCompare(textB);
            });

            if (column.classList.contains("desc")) {
                rows.reverse();
                column.classList.remove("desc");
            } else {
                column.classList.add("desc");
            }

            table.tBodies[0].append(...rows);
        }

        function filterStock() {
            var input = document.getElementById("stockSearch");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("stockTable");
            var rows = table.getElementsByTagName("tr");

            for (var i = 1; i < rows.length+1; i++) {
                var name = rows[i].cells[1].innerHTML.toLowerCase();
                if (name.includes(filter)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
        function editComponent(button) {
        var row = button.closest('tr');
        var componentId = row.querySelector('.component-id').innerText;
        var componentName = row.querySelector('.component-name').innerText;
        var componentQuantity = row.querySelector('.component-quantity').innerText;
        row.innerHTML = `
            <td class="component-id">${componentId}</td>
            <td><input type="text" value="${componentName}" class="edit-input edit-name"></td>
            <td class="component-quantity">${componentQuantity}</td>
            <td><button class="save-btn edit-action-btn"><i class="far fa-save"></i></button></td>
            <td><button class="cancel-btn edit-action-btn"><i class="far fa-times-circle"></i></button></td>
        `;

        row.querySelector('.save-btn').addEventListener('click', function() {
            saveComponent(row, componentId,componentQuantity );
        });

        row.querySelector('.cancel-btn').addEventListener('click', function() {
            location.reload();
        });
    }

    function saveComponent(row, componentId, componentQuantity) {
    var editedName = row.querySelector('.edit-name').value;

    fetch('update-component.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `componentId=${encodeURIComponent(componentId)}&componentName=${encodeURIComponent(editedName)}&componentQuantity=${encodeURIComponent(componentQuantity)}`,
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            console.error('Server error:', data.message);
            alert('Error saving customer: ' + data.message);
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
        alert('Error saving customer: ' + error.message);
    });
}


    </script>
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
                
                <a href="#" onclick="window.location.href = 'stock.php'" class="active">
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
        <main>
        <h1>Stock List</h1>
    <div class="content">

        <input type="text" id="stockSearch" oninput="filterStock()" placeholder="Search by Name &#128270;">
        <table id="stockTable">
            <thead>
                <tr>
                    <th onclick="toggleSort(this)">Component ID</th>
                    <th onclick="toggleSort(this)">Component Name</th>
                    <th>Quantity</th>
                    <th colspan="2" class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "mah heng motor database";
                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM component";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='component-id'>" . $row["Component_ID"] . "</td>";
                        echo "<td  class='component-name'>" . $row["Component_Name"] . "</td>";
                        echo "<td class='component-quantity'>" . $row["Component_Quantity"] . "</td>";
                        echo "<td><button class='edit-btn' data-id='" . $row['Component_ID'] . "' onclick='editComponent(this)'><i class='far fa-edit'></i></button></td>";
                        if ($row["Component_Quantity"] == 0) {
                            echo "<td><button class='delete-btn' data-id='" . $row['Component_ID'] . "'><i class='far fa-trash-alt'></i></button></td>";
                        } else {
                            echo "<td><i class='fas fa-check'></i></td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No component found.</td></tr>";
                }

                $conn->close();
            ?>


            </tbody>
        </table>
    </div>
            </main>
        <script type="text/javascript" src="../scripts/global-scripts.js"></script>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function (event) {
                    var componentId = button.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this component?')) {
                        fetch('delete-handlers/delete-component.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'componentId=' + encodeURIComponent(componentId),
                        })
                        .then(function (response) {
                            return response.json();
                        })
                        .then(function (data) {
                            if (data.success) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(function (error) {
                            console.error('Error:', error);
                            alert('Error deleting component.');
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
