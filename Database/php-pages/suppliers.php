<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers | Mah Heng Motor Enterprise</title>
    <link rel="stylesheet" href="../stylesheets/style1.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="icon" href="../image/logo.png" type="image/png">
    <style>
               .content {
            margin-left: 250px;
            padding: 40px;
            width: calc(100% - 250px);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }

            #customerSearch {
                max-width: 300px;
            }
        }

        @media (max-width: 576px) {
            .content {
                margin-left: 150px;
                width: calc(100% - 150px);
            }

            #customerSearch {
                max-width: 250px;
            }
        }
    </style>

    <script>
        function toggleSort(column) {
            var table = document.getElementById("supplierTable");
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

        function filterSuppliers() {
            var input = document.getElementById("supplierSearch");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("supplierTable");
            var rows = table.getElementsByTagName("tr");

            for (var i = 1; i < rows.length; i++) {
                var name = rows[i].cells[1].innerHTML.toLowerCase();
                if (name.includes(filter)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        function editSupplier(button) {
            var row = button.closest('tr');
            var supplierId = row.querySelector('.supplier-id').innerText;
            var supplierName = row.querySelector('.supplier-name').innerText;
            var supplierContact = row.querySelector('.supplier-contact').innerText;

            row.innerHTML = `
                <td class="supplier-id">${supplierId}</td>
                <td><input type="text" value="${supplierName}" class="edit-input edit-name"></td>
                <td><input type="text" value="${supplierContact}" class="edit-input edit-contact"></td>
                <td><button class="save-btn edit-action-btn"><i class="far fa-save"></i></button></td>
                <td><button class="cancel-btn edit-action-btn"><i class="far fa-times-circle"></i></button></td>
            `;

            row.querySelector('.save-btn').addEventListener('click', function() {
                saveSupplier(row, supplierId);
            });

            row.querySelector('.cancel-btn').addEventListener('click', function() {
                location.reload();
            });
        }

        function saveSupplier(row, supplierId) {
            var editedName = row.querySelector('.edit-name').value;
            var editedContact = row.querySelector('.edit-contact').value;

            fetch('edit-supplier.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `supplierId=${encodeURIComponent(supplierId)}&supplierName=${encodeURIComponent(editedName)}&supplierContact=${encodeURIComponent(editedContact)}`,
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
                    alert('Error saving supplier: ' + data.message);
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                alert('Error saving supplier: ' + error.message);
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
                <a href="#" onclick="window.location.href = 'suppliers.php'" class="active">
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
        <main>
        <h1>Supplier List</h1>
        <input type="text" id="supplierSearch" oninput="filterSuppliers()" placeholder="Search by Name &#128270;">
        <table id="supplierTable">
            <thead>
                <tr>
                    <th onclick="toggleSort(this)">Supplier ID</th>
                    <th onclick="toggleSort(this)">Supplier Name</th>
                    <th>Supplier Contact Number</th>
                    <th colspan="2" class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
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

                // Fetch supplier data from the database
                $sql = "SELECT * FROM supplier_details";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='supplier-id' >" . $row["Supplier_ID"] . "</td>";
                        echo "<td class='supplier-name'>" . $row["Supplier_Name"] . "</td>";
                        echo "<td class='supplier-contact'>" . $row["Supplier_Contact_Number"] . "</td>";
                        echo "<td><button class='edit-btn' onclick='editSupplier(this)'><i class='far fa-edit'></i></button></td>";
                        echo "<td><button class='delete-btn' data-id='" . $row['Supplier_ID'] . "'><i class='far fa-trash-alt'></i></button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No suppliers found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var deleteButtons = document.querySelectorAll('.delete-btn');

                deleteButtons.forEach(function (button) {
                    button.addEventListener('click', function (event) {
                        var supplierId = button.getAttribute('data-id');
                        if (confirm('Are you sure you want to delete this supplier?')) {
                            fetch('delete-handlers/delete-supplier.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: 'supplierId=' + encodeURIComponent(supplierId),
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
                                alert('Error deleting supplier.');
                            });
                        }
                    });
                });
            });
        </script>
    </div>
    <script type="text/javascript" src="../scripts/global-scripts.js"></script>
</body>
</html>
