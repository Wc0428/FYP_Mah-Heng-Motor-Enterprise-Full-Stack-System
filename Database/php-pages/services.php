<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services | Mah Heng Motor Enterprise</title>
    <link rel="stylesheet" href="../stylesheets/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="icon" href="../image/logo.png" type="image/png">
    <style>
.search-container {
    display: flex;
    justify-content: center;
    margin-bottom: 10px;
}

.search-container label {
    margin-left: 20px; /* Adjust as needed for spacing */
}

.search-container input[type="text"],
.search-container input[type="date"] {
    width: 30%; /* Adjust as needed */
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
                <a href="#" onclick="window.location.href = 'services.php'" class="active">
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
        <main>
    <h1>Sales Management</h1>
    <div class="search-container">
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names...&#128270;">
        <label for="startDateInput">Start Date:</label>
        <input type="date" id="startDateInput" onchange="searchTable()">
        <label for="endDateInput">End Date:</label>
        <input type="date" id="endDateInput" onchange="searchTable()">  
    </div>
    <table id="serviceTable">
        <thead>
            <tr>
                <th style='text-align: center;'>Service ID</th>
                <th id="dateHeader" onclick="toggleSort()">Service Date</th>
                <th>Motor ID</th>
                <th>Customer Name</th>
                <th class="des">Service Description</th>
                <th class="abc">Service Total Price (RM)</th>
                <th colspan="3" class="actions">Actions</th>
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

            // Fetch service data from the database
            $sql = "SELECT service.Service_ID, service.Service_Date, customer_details.Customer_Name, service.Description, service.Service_Total_Price, service.Motor_ID FROM service
                    INNER JOIN customer_details ON service.Customer_ID = customer_details.Customer_ID
                    ORDER BY service.Service_Date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='text-align: center;'>" . $row["Service_ID"] . "</td>";
                    echo "<td>" . $row["Service_Date"] . "</td>";
                    echo "<td>" . $row["Motor_ID"] . "</td>";
                    echo "<td>" . $row["Customer_Name"] . "</td>";
                    echo "<td>" . $row["Description"] . "</td>";
                    echo "<td id=total".$row['Service_ID'].">" . $row["Service_Total_Price"] . "</td>";
                    echo "<td><p><a href='#' data-id='".$row['Service_ID']."' class='more'><i class='fas fa-info-circle'></i></a></p></td>";
                    echo "<td><button class='edit-btn' data-id='" . $row['Service_ID'] . "'><i class='far fa-edit'></i></button></td>"; // Edit button added
                    echo "<td><button class='delete-btn' data-id='" . $row['Service_ID'] . "'><i class='far fa-trash-alt'></i></button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No services found.</td></tr>";
            }

            $conn->close();
            ?>
           
       </tbody>
    </table>
    <div class="popup2 popup">
        <span class="close" >&#10006;</span>
        <h2>SERVICES COMPONENTS</h2>
        <br>
        <table style=" width: 100%;">
            <thead>
                <tr>
                    <th>Component Name</th>
                    <th>Quantity</th>
                    <th>Price Per Unit (RM)</th>
                    <th>Subtotal (RM)</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div id="addServiceForm" class="popup1 popup">
        <span class="close" onclick="toggleAddServiceForm()">&times;</span>
        <h2 style="text-align: center;">Add Service</h2>
        <form id="serviceForm" action="./form-handlers/services-post.php" method="post">
            <div class="form-field">
                <label>
                    <input type="radio" name="customerType" value="existing" onclick="toggleCustomerFields()" checked> Existing Customer
                </label>
                <label>
                    <input type="radio" name="customerType" id="newCustomerRadio" value="new" onclick="toggleCustomerFields()"> New Customer
                </label>
            </div>
            <div class="form-field" id="customer-name-field">
                <label for="customerName">Customer Name:</label>
                <input type="text" id="customerNameText" name="customerName">
                <select id="customerNameDropdown" name="customerID">
                    <?php
                    // Fetch customer data from the database
                    $conn = new mysqli($servername, $username, $password, $database);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT Customer_ID, Customer_Name, Customer_Contact_Number FROM customer_details";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["Customer_ID"]."'>" . $row["Customer_Name"] . " (" . $row["Customer_Contact_Number"] . ")</option>";
                        }
                    }

                    $conn->close();
                    ?>
              </select> 
            </div>
            <div class="form-field" id="customer-phone-field">
                <label for="customerPhone">Customer Phone:</label>
                <input type="text" id="customerPhone" name="customerPhone"><br>
            </div>
            <div class="form-field">
                <label for="motorcycleId">Motorcycle ID:</label>
                <input type="text" id="motorcycleId" name="motorcycleId" required><br>
            </div>
            <div class="form-field">
                <label for="serviceDate">Service Date:</label>
                <input type="date" id="serviceDate" name="serviceDate" required><br>
            </div>

            <div id="componentFieldsContainer"></div>
            
            <div class="form-field">
            <button type="button" onclick="addServiceComponent()" class="add-service-btn">Add Sales</button>
            </div>
            <div class="form-field">
                <label for="totalPrice">Total Price (RM):</label>
                <input type="number" id="totalPrice" name="totalPrice" step="0.1" readonly required><br>
            </div>
            <div class="form-field">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea><br>
            </div>
            <div class="form-field" >
            <input type="submit" id="submitButton" value="Submit" >            </div>
        </form>
    </div>
</main>
<div class="fixed-button-container">
    <button class="fixed-button" onclick="toggleAddServiceForm()">Add Service</button>
</div>

<aside style="display:none;">
    <button id="close-btn">Close Menu</button>
    <!-- Your side menu content here -->
</aside>



    <!-- e           d            i              t  -->
                    <div id="editServiceForm" class="popup1 popup">
                    <span class="close" onclick="toggleEditServiceForm()">&times;</span>
                    <!-- Edit Service Form -->
                    <h2 style="text-align: center;">Edit Service</h2>
                    <form id="editServiceForm" action="./form-handlers/update-service.php" method="post">

                <div class="form-field">
                    <label>
                        <input type="radio" name="customerType" value="existing" onclick="toggleCustomerFieldsEdit()" checked>Existing Customer
                    </label>
                    <label>
                        <input type="radio" name="customerType" id="editNewCustomerRadio" value="new" onclick="toggleCustomerFieldsEdit()">New Customer
                    </label>
                </div>
                <input type="hidden" id="editServiceId" name="serviceID">

                <div class="form-field" id="editCustomer-name-field">
                    <label for="customerName">Customer Name:</label>
                    <input type="text" id="editCustomerNameText" name="customerName" >
                    <select id="editCustomerNameDropdown" name="customerID" >
                        <?php
                        // Fetch customer data from the database
                        $conn = new mysqli($servername, $username, $password, $database);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT Customer_ID, Customer_Name, Customer_Contact_Number FROM customer_details";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='".$row["Customer_ID"]."'>" . $row["Customer_Name"] . " (" . $row["Customer_Contact_Number"] . ")</option>";
                            }
                        }

                        $conn->close();
                        ?>
                    </select>
                </div>

                <div class="form-field" id="editCustomer-phone-field">               
                    <label for="customerPhone">Customer Phone:</label>
                    <input type="text" id="customerPhone" name="customerPhone" ><br>
                </div>


                <div class="form-field">
                    <label for="motorcycleId">Motorcycle ID:</label>
                    <input type="text" id="editMotorcycleId" name="motorcycleId" required><br>
                </div>

                <div class="form-field">
                    <label for="serviceDate">Service Date:</label>
                    <input type="date" id="editServiceDate" name="serviceDate" required><br>
                </div>

                <div id="editComponentFieldsContainer">
                </div>
                
                <div class="form-field">
            <button type="button" onclick="addServiceComponentWithPlaceholder()" class="add-service-btn">Add Sales</button>

                <div class="form-field">
                    <label for="totalPrice">Total Price (RM):</label>
                    <input type="number" id="editTotalPrice" name="totalPrice" step="0.1" readonly required><br>
                </div>

                <div class="form-field">
                    <label for="description">Description:</label>
                    <textarea id="editDescription" name="description" required></textarea><br>
                </div>

                <div class="form-field">
                <input type="submit" id="editSubmitButton" value="Submit" >            </div>
                </div>

            </form>
                </div>
                <script src="../scripts/index.js"></script>
        <script type="text/javascript" src="../scripts/global-scripts.js"></script>
    </div>

    <script>
        // Function to toggle the sort order of the service date column
        function toggleSort() {
            var table = document.getElementById("serviceTable");
            var rows = Array.from(table.getElementsByTagName("tr"));
            var header = rows.shift();
            var index = Array.from(header.getElementsByTagName("th")).indexOf(document.getElementById("dateHeader"));

            rows.sort(function(a, b) {
                var dateA = new Date(a.cells[index].innerHTML);
                var dateB = new Date(b.cells[index].innerHTML);
                return dateA - dateB;
            });

            if (table.classList.contains("desc")) {
                rows.reverse();
                table.classList.remove("desc");
            } else {
                table.classList.add("desc");
            }

            table.tBodies[0].append(...rows);
        }

        function updateGrandTotal(isAdd){
            if (isAdd){
                var totalPrice = document.getElementById("totalPrice");
            }else{
                var totalPrice = document.getElementById("editTotalPrice");
            }
            totalPrice.value = 0;
            subTotals = document.querySelectorAll(".subtotal");
            subTotals.forEach(subTotal=> {
                totalPrice.value=parseFloat(totalPrice.value) + parseFloat(subTotal.value);
            });
            totalPrice.value = (Math.round(totalPrice.value * 100) / 100).toFixed(2);
        }


        function addServiceComponentWithPlaceholder(serviceComponentData = {}) {
            var componentAndQuantity ={}
            var componentFieldsContainer = document.getElementById("editComponentFieldsContainer");
            
            var numComponents = componentFieldsContainer.childElementCount;
            var totalPrice = document.getElementById("totalPrice");
            totalPrice.value = 0;
            var div = document.createElement("div");
            var label = document.createElement("label");
            label.classList.add("service-component-label")
            var select = document.createElement("select");
            select.name = "serviceComponents[" + numComponents + "][componentName]";
            select.required = true;

            <?php
                // Replace with your database connection details
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "mah heng motor database";
                // Fetch component names from the database and generate options dynamically
                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $selectComponentsSql = "SELECT Component_ID, Component_Name, Component_Quantity FROM component";
                $result = $conn->query($selectComponentsSql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "var option = document.createElement('option');";
                        echo "option.value = '" . $row["Component_ID"] . "';";
                        echo "option.textContent = '" . $row["Component_Name"] . "';";
                        echo "option.textContent = '" . $row["Component_Name"] . "';";
                        echo "select.appendChild(option);";
                        echo "componentAndQuantity['".$row["Component_ID"]."'] = ".$row["Component_Quantity"].";";
                    }
                }
                else{
                    echo "var option = document.createElement('option');";
                    echo "option.value = 'new';";
                    echo "option.textContent = 'No Existing components: Please Add Components at Invoice Tab';";
                    echo "select.appendChild(option);";
                }
                $conn->close();
            ?>

            if (Object.keys(serviceComponentData).length > 0) {
                var defaultComponentId = serviceComponentData["componentId"];
                var options = select.options;


                // Select the default component
                for (var i = 0; i < options.length; i++) {
                    if (options[i].value == defaultComponentId) {
                        options[i].selected = true;
                        console.log(options[i].value)
                        break; // Once found, no need to continue looping
                    }
                }
            }
            select.oninput =function changeMaxQuantity(){quantityInput.max= componentAndQuantity[select.value]};
            var quantityLabel = document.createElement("label");
            quantityLabel.textContent = "Quantity:";
            var quantityInput = document.createElement("input");
            
            if (Object.keys(serviceComponentData).length >0) {
                quantityInput.value = serviceComponentData["serviceComponentQuantity"]
            }
            quantityInput.type = "number";
            quantityInput.name = "serviceComponents[" + numComponents + "][quantity]";
            quantityInput.min = "1";
            quantityInput.step = "1";
            quantityInput.required = true;
            quantityInput.oninput = function calculateTotal(){
                subTotalInput.value=(Math.round(quantityInput.value * priceInput.value * 100) / 100).toFixed(2);
                updateGrandTotal(false)
            };
            quantityInput.max= componentAndQuantity[select.value]

            var priceLabel = document.createElement("label");
            priceLabel.textContent = "Price per piece (RM):";
            var priceInput = document.createElement("input");
            priceInput.type = "number";
            priceInput.name = "serviceComponents[" + numComponents + "][pricePerPiece]";
            priceInput.step = "0.01";
            priceInput.required = true;
            priceInput.oninput = function calculateTotal(){
                subTotalInput.value=(Math.round(quantityInput.value * priceInput.value * 100) / 100).toFixed(2);
                updateGrandTotal(false)
            };

            var subTotalLabel = document.createElement("label");
            subTotalLabel.textContent = "Sub Total (RM):";

            var subTotalInput = document.createElement("input");
            subTotalInput.classList.add("subtotal");
            subTotalInput.type = "number";
            subTotalInput.step = "0.01";
            subTotalInput.value = "0";
            subTotalInput.name = "serviceComponents[" + numComponents + "][subTotal]";
            subTotalInput.readOnly = true;
            if (Object.keys(serviceComponentData).length >0) {
                priceInput.value = serviceComponentData["serviceComponentPricePerUnit"]
                subTotalInput.value=(Math.round(quantityInput.value * priceInput.value * 100) / 100).toFixed(2);
                updateGrandTotal(false)
            }
            var removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.textContent = "Remove Component";
            removeButton.onclick = function() {
                componentFieldsContainer.removeChild(div);
                // Re-label the remaining service components
                var labels = componentFieldsContainer.getElementsByClassName("service-component-label");
                for (var i = 0; i < labels.length; i++) {
                    labels[i].innerHTML = "Service Component " + (i+1) + ":";
                }
                updateGrandTotal(false)
            };
            let priceContainer = document.createElement("div");
            let quantityContainer = document.createElement("div");
            let subtotalContainer = document.createElement("div");
            // Append elements to the container div
            priceContainer.appendChild(priceLabel);
            priceContainer.appendChild(priceInput);
            quantityContainer.appendChild(quantityLabel);
            quantityContainer.appendChild(quantityInput);
            subtotalContainer.appendChild(subTotalLabel);
            subtotalContainer.appendChild(subTotalInput);
            var priceWidth = window.getComputedStyle(priceInput).getPropertyValue("width");
            
            // Apply CSS class to the container div for styling
            priceContainer.classList.add("price-container");
            quantityContainer.classList.add("quantity-container");
            subtotalContainer.classList.add("subtotal-container");
            div.appendChild(label);
            div.appendChild(select);
            div.appendChild(quantityContainer);
            div.appendChild(priceContainer); 
            div.appendChild(subtotalContainer);
            div.appendChild(removeButton);
            componentFieldsContainer.appendChild(div);
            // Re-label the remaining service components
            var labels = componentFieldsContainer.getElementsByClassName("service-component-label");
            for (var i = 0; i < labels.length; i++) {
                labels[i].innerHTML = "<span style='font-weight: bold;'>Service Component " + (i+1) + ":</span>";
            }
            updateGrandTotal(false)
        }


        // Function to add a service component
    window.onload = function() {
        document.getElementById("serviceForm").addEventListener("submit", function(event) {
            if (!hasServiceComponent()) {
                event.preventDefault();
                alert("Please add at least one component before submitting the form.");
            }
        });

        document.getElementById("editServiceForm").addEventListener("submit", function(event) {
        console.log("sad");
            if (!hasEditServiceComponent()) {
                event.preventDefault();
                alert("Please add at least one component before submitting the form.");
            }
        });
    };

function addServiceComponent() {
    var componentAndQuantity = {};
    var componentFieldsContainer = document.getElementById("componentFieldsContainer");
    var numComponents = componentFieldsContainer.childElementCount;
    var totalPrice = document.getElementById("totalPrice");
    totalPrice.value = 0;
    var div = document.createElement("div");
    var label = document.createElement("label");
    label.classList.add("service-component-label");
    var select = document.createElement("select");
    select.name = "serviceComponents[" + numComponents + "][componentName]";
    select.required = true;

    <?php
    // Replace with your database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "mah heng motor database";
    // Fetch component names from the database and generate options dynamically
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $selectComponentsSql = "SELECT Component_ID, Component_Name, Component_Quantity FROM component";
    $result = $conn->query($selectComponentsSql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "var option = document.createElement('option');";
            echo "option.value = '" . $row["Component_ID"] . "';";
            echo "option.textContent = '" . $row["Component_Name"] . "';";
            echo "select.appendChild(option);";
            echo "componentAndQuantity['" . $row["Component_ID"] . "'] = " . $row["Component_Quantity"] . ";";
        }
    } else {
        echo "var option = document.createElement('option');";
        echo "option.value = 'new';";
        echo "option.textContent = 'No Existing components: Please Add Components at Invoice Tab';";
        echo "select.appendChild(option);";
    }
    $conn->close();
    ?>

    select.oninput = function changeMaxQuantity() {
        quantityInput.max = componentAndQuantity[select.value];
    };

    var quantityLabel = document.createElement("label");
    quantityLabel.textContent = "Quantity:";
    var quantityInput = document.createElement("input");
    quantityInput.type = "number";
    quantityInput.name = "serviceComponents[" + numComponents + "][quantity]";
    quantityInput.min = "1";
    quantityInput.step = "1";
    quantityInput.required = true;
    quantityInput.oninput = function calculateTotal() {
        subTotalInput.value = (Math.round(quantityInput.value * priceInput.value * 100) / 100).toFixed(2);
        updateGrandTotal(true);
    };
    quantityInput.max = componentAndQuantity[select.value];

    var priceLabel = document.createElement("label");
    priceLabel.textContent = "Price per piece (RM):";

    var priceInput = document.createElement("input");
    priceInput.type = "number";
    priceInput.name = "serviceComponents[" + numComponents + "][pricePerPiece]";
    priceInput.step = "0.01";
    priceInput.required = true;
    priceInput.oninput = function calculateTotal() {
        subTotalInput.value = (Math.round(quantityInput.value * priceInput.value * 100) / 100).toFixed(2);
        updateGrandTotal(true);
    };

    var subTotalLabel = document.createElement("label");
    subTotalLabel.textContent = "Sub Total (RM):";

    var subTotalInput = document.createElement("input");
    subTotalInput.classList.add("subtotal");
    subTotalInput.type = "number";
    subTotalInput.step = "0.01";
    subTotalInput.value = "0";
    subTotalInput.name = "serviceComponents[" + numComponents + "][subTotal]";
    subTotalInput.readOnly = true;

    var removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.textContent = "Remove Component";
    removeButton.onclick = function() {
        componentFieldsContainer.removeChild(div);
        // Re-label the remaining service components
        var labels = componentFieldsContainer.getElementsByClassName("service-component-label");
        for (var i = 0; i < labels.length; i++) {
            labels[i].innerHTML = "Service Component " + (i + 1) + ":";
        }
        updateGrandTotal(true);
    };

    let priceContainer = document.createElement("div");
    let quantityContainer = document.createElement("div");
    let subtotalContainer = document.createElement("div");

    priceContainer.appendChild(priceLabel);
    priceContainer.appendChild(priceInput);
    quantityContainer.appendChild(quantityLabel);
    quantityContainer.appendChild(quantityInput);
    subtotalContainer.appendChild(subTotalLabel);
    subtotalContainer.appendChild(subTotalInput);

    priceContainer.classList.add("price-container");
    quantityContainer.classList.add("quantity-container");
    subtotalContainer.classList.add("subtotal-container");

    div.appendChild(label);
    div.appendChild(select);
    div.appendChild(quantityContainer);
    div.appendChild(priceContainer);
    div.appendChild(subtotalContainer);
    div.appendChild(removeButton);

    componentFieldsContainer.appendChild(div);

    var labels = componentFieldsContainer.getElementsByClassName("service-component-label");
    for (var i = 0; i < labels.length; i++) {
        labels[i].innerHTML = "<span style='font-weight: bold;'>Service Component " + (i + 1) + ":</span>";
    }
    updateGrandTotal(true);
}

function hasServiceComponent() {
    var componentFieldsContainer = document.getElementById("componentFieldsContainer");
    var childrenPresent = componentFieldsContainer.childElementCount > 0;
    return childrenPresent;
}

function hasEditServiceComponent() {
    var editComponentFieldsContainer = document.getElementById("editComponentFieldsContainer");
    var childrenPresent = editComponentFieldsContainer.childElementCount > 0;
    return childrenPresent;
}

function displayMessage(message) {
    var messageElement = document.getElementById("messageElement");
    if (!messageElement) {
        messageElement = document.createElement("div");
        messageElement.id = "messageElement";
        messageElement.style.color = "red";
        messageElement.style.marginTop = "10px";
        messageElement.style.textAlign = "center";
        document.getElementById("serviceForm").insertBefore(messageElement, document.getElementById("serviceForm").firstChild);
    }
    messageElement.textContent = message;
}


function toggleCustomerFieldsEdit() {
    var newCustomerRadio = document.getElementById("editNewCustomerRadio");
    var customerNameDropdown = document.getElementById("editCustomerNameDropdown");
    var customerNameText = document.getElementById("editCustomerNameText");
    var customerPhoneField= document.getElementById("editCustomer-phone-field");

    if (!newCustomerRadio.checked) {
        customerNameDropdown.style.display = "block";
        customerNameDropdown.required = true;
        customerNameText.style.display = "none";
        customerNameText.required = false;
        customerPhoneField.style.display = "none";
        customerPhoneField.required = false;
        
    } else {
        customerNameDropdown.style.display = "none";
        customerNameDropdown.required = false;
        customerNameText.style.display = "block";
        customerNameText.required = true;
        customerPhoneField.style.display = "block";
        customerPhoneField.required = true;
    }
}
        toggleCustomerFieldsEdit()

        function toggleCustomerFields() {
            var newCustomerRadio = document.getElementById("newCustomerRadio");
            var customerNameDropdown = document.getElementById("customerNameDropdown");
            var customerNameText = document.getElementById("customerNameText");
            var customerPhoneField= document.getElementById("customer-phone-field");

            if (!newCustomerRadio.checked) {
                customerNameDropdown.style.display = "block";
                customerNameDropdown.required = true;
                customerNameText.style.display = "none";
                customerNameText.required = false;
                customerPhoneField.style.display = "none";
                customerPhoneField.required = false;
                
            } else {
                customerNameDropdown.style.display = "none";
                customerNameDropdown.required = false;
                customerNameText.style.display = "block";
                customerNameText.required = true;
                customerPhoneField.style.display = "block";
                customerPhoneField.required = true;

            }
        }
        addServiceComponent();
        toggleCustomerFields();
        //When document is ready
        $(document).ready(function () {
            var isOpen = false;
            //If More Details button is clicked, toggle popup
            $(".more").click(function (e) {
                if(isOpen){
                    closePopup();
                }else{
                    e.preventDefault();
                    serviceId = $(this).data("id")
                    openPopup(serviceId);
                }
            });

            //If popup is open popup focus is lost, toggle popup (close it)
            $(document).click(function (e) {
                if (isOpen && !$(e.target).closest('.popup2').length && !$(e.target).closest('.more').length) {
                    closePopup();
                }
            });

            //If popup's close button is clicked, toggle popup (close it)
            $(".popup2 .close").click(function () {
                closePopup();
            });

            function openPopup(serviceId) {
                isOpen = true;
                $.ajax({
                    type: "POST",
                    url: "./form-handlers/service-component-ajax.php",
                    data: { 'id': serviceId },
                    success: function(response) {
                        // Handle the response from PHP here
                        $("div.popup2 tbody").html(response);
                        $("div.popup2").fadeIn();
                        $(".popup2").find("h2:last").remove();
                        $(".popup2").append("<h2>TOTAL PRICE : RM" + $("#total"+serviceId).text() +"</h2>")
                    }
                }); 
            }

            function closePopup(){
                $("div.popup2").fadeOut();
                isOpen = false;
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
    // Select all delete buttons
    var deleteButtons = document.querySelectorAll('.delete-btn');
    
    // Add click event listener to each delete button
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            var serviceId = button.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this service?')) {
                // Send delete request to the backend using fetch or XMLHttpRequest
                fetch('delete-handlers/delete-service.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'serviceId=' + encodeURIComponent(serviceId),
                })
                .then(function (response) {
                    // Parse JSON response
                    return response.json();
                })
                .then(function (data) {
                    // Update UI based on response
                    if (data.success) {
                        // Show success message on the page
                        alert(data.message);
                        // You can also update UI as needed here
                        // For example, reload the page or remove the deleted service row
                        location.reload();
                    } else {
                        // Show error message on the page
                        alert(data.message);
                    }
                })
                .catch(function (error) {
                    console.error('Error:', error);
                    alert('Error deleting service!!!!.');
                });
            }
        });
    });
});
function toggleAddServiceForm() {
            var addServiceForm = document.getElementById('addServiceForm');
            addServiceForm.classList.toggle('display');
        }

        function adjustRowSpacing() {
        const tableRows = document.querySelectorAll("#serviceTable tbody tr");
        tableRows.forEach(row => {
            const rowHeight = row.clientHeight;
            row.style.marginBottom = `${rowHeight}px`;
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Select all edit buttons
        var editButtons = document.querySelectorAll('.edit-btn');
        
        // Add click event listener to each edit button
        editButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                var serviceId = button.getAttribute('data-id');
                // Show the edit form and fill it with service data
                showServiceEditForm(serviceId);
            });
        });
    });

    function jsonToArrayOfObjects(jsonObj) {
        return Object.keys(jsonObj).map(key => jsonObj[key]);
    }


    // Function to display edit form with service data
    function showServiceEditForm(serviceId) {
    var componentFieldsContainer = document.getElementById("editComponentFieldsContainer");
    while (componentFieldsContainer.firstChild) {
        componentFieldsContainer.removeChild(componentFieldsContainer.firstChild);
}        // Fetch service data using AJAX
        fetch('get-service.php?id=' + encodeURIComponent(serviceId))
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                // Fill edit form fields with service data
                document.getElementById("editDescription").value = data.row0.description;
                document.getElementById("editServiceDate").value = data.row0.serviceDate;
                document.getElementById("editMotorcycleId").value =data.row0.motorcycleId;
                document.getElementById("editServiceId").value =data.row0.serviceId;
                var customerNameDropdown = document.getElementById("editCustomerNameDropdown");
                var options = customerNameDropdown.options;
                for (var i = 0; i < options.length; i++) {
                    if (options[i].value == data.row0.customerId) {
                        options[i].selected = true;
                        console.log(options[i].value)
                        break; // Once found, no need to continue looping
                    }
                }

                const arrayOfObjects = jsonToArrayOfObjects(data);
                for (let i = 0; i < arrayOfObjects.length; i++) {
                    row = arrayOfObjects[i.toString()]
                addServiceComponentWithPlaceholder(serviceComponentData = row)
                }
                updateGrandTotal(false)
                // TO DO: Handle Service Component
                // Show the edit form popup/modal
                toggleEditServiceForm();
            })
            .catch(function (error) {
                console.error('Error fetching service data:', error);
                alert('Error fetching service data. Please try again.',error);
            });
    }

    // Function to toggle display of edit service form
    function toggleEditServiceForm() {
        var editPopup = document.getElementById("editServiceForm");
        editPopup.classList.toggle("display");
    }

    // Function to handle edit button click
function handleEdit(serviceId) {
    // Send AJAX request to fetch service data
    $.ajax({
        url: 'fetch-service.php', // Replace with your PHP script to fetch service data
        method: 'GET',
        data: { serviceId: serviceId },
        success: function(response) {
            // Populate form fields with fetched data
            populateForm(response);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// Function to populate form fields with fetched data
function populateForm(data) {
    // Parse the fetched data JSON and populate form fields
    var service = JSON.parse(data);
    document.getElementById('editCustomerNameText').value = service.customerName;
    document.getElementById('editCustomerPhone').value = service.customerPhone;
    // Populate other form fields similarly
}

// Function to submit updated data
// function submitUpdatedData() {
//     console.log("No error")
//     // Collect updated form data
//     var formData = new FormData(document.getElementById('editServiceForm'));
//     // Send AJAX request to update data
//     $.ajax({
//         url: 'update-service.php', // Replace with your PHP script to update service data
//         method: 'POST',
//         data: formData,
//         contentType: false,
//         processData: false,
//         success: function(response) {

//         },
//         error: function(xhr, status, error) {
//             console.error(error);
//         }
//     });
// }

function searchTable() {
            var input, filter, table, tr, td, i, txtValue, startDateInput, endDateInput, startDate, endDate, dateFilter;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("serviceTable");
            tr = table.getElementsByTagName("tr");
            startDateInput = document.getElementById("startDateInput").value;
            endDateInput = document.getElementById("endDateInput").value;

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[3]; // Change index based on the column where customer name is located
                dateFilter = tr[i].getElementsByTagName("td")[1]; // Change index based on the column where service date is located
                if (td && dateFilter) {
                    txtValue = td.textContent || td.innerText;
                    startDate = new Date(startDateInput);
                    endDate = new Date(endDateInput);
                    serviceDate = new Date(dateFilter.textContent || dateFilter.innerText);
                    if ((txtValue.toUpperCase().indexOf(filter) > -1) &&
                        (!startDateInput || serviceDate >= startDate) &&
                        (!endDateInput || serviceDate <= endDate)) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function toggleSort() {
            var dateHeader = document.getElementById("dateHeader");
            var startDateInput = document.getElementById("startDateInput");
            var endDateInput = document.getElementById("endDateInput");

            if (dateHeader.classList.contains("ascending")) {
                dateHeader.classList.remove("ascending");
                dateHeader.classList.add("descending");
            } else {
                dateHeader.classList.remove("descending");
                dateHeader.classList.add("ascending");
            }

            searchTable();
        }
    </script>
</body>
</html>