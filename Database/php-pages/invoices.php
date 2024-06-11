 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices | Mah Heng Motor Enterprise</title>
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
                <a href="#" onclick="window.location.href = 'services.php'" >
                    <span class="material-icons-sharp">
                        inventory
                    </span>
                    <h3>Sales</h3>
                </a>
                <a href="#" onclick="window.location.href = 'invoices.php'" class="active">
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
    <h1>Invoices Management</h1>
    <div class="search-container">
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names...&#128270;">
        <label for="startDateInput">Start Date:</label>
        <input type="date" id="startDateInput" onchange="searchTable()">
        <label for="endDateInput">End Date:</label>
        <input type="date" id="endDateInput" onchange="searchTable()">  
    </div>
        <!-- Add Table For all Services -->
        <table id="invoiceTable">
            <thead>
                <tr>
                    <th style='text-align: center;'>Invoice ID</th>
                    <th id="dateHeader" onclick="toggleSort()">Invoice Date</th>
                    <th>Supplier Name</th>
                    <th>Supplier Contact Number</th>
                    <th>Invoice Total Price(RM)</th>
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

                // Fetch invoice data from the database
                $sql = "SELECT invoice_details.Invoice_ID, invoice_details.Invoice_Date, invoice_details.Invoice_Total_Price, supplier_details.Supplier_Name,supplier_details.Supplier_Contact_Number FROM invoice_details
                        INNER JOIN supplier_details ON  invoice_details.Supplier_ID = supplier_details.Supplier_ID
                        ORDER BY invoice_details.Invoice_Date DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='text-align: center;'>" . $row["Invoice_ID"] . "</td>";
                        echo "<td>" . $row["Invoice_Date"] . "</td>";
                        echo "<td>" . $row["Supplier_Name"] . "</td>";
                        echo "<td>" . $row["Supplier_Contact_Number"] . "</td>";
                        echo "<td id=total".$row['Invoice_ID'].">" . $row["Invoice_Total_Price"] . "</td>";
                        echo "<td><p><a href='#' data-id='".$row['Invoice_ID']."' class='more'><i class='fas fa-info-circle'></i></a></p></td>";
                        echo "<td><button class='edit-btn' data-id='" . $row['Invoice_ID'] . "'><i class='far fa-edit'></i></button></td>"; // Edit button added
                        echo "<td><button class='delete-btn' data-id='" . $row['Invoice_ID'] . "'><i class='far fa-trash-alt'></i></button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No invoices found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <div class="popup2 popup">
            <span class="close">&#10006;</span>
            <h2>INVOICES COMPONENTS</h2>
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
                <tbody>

                </tbody>
            </table>
        </div>
      <!-- Add Service Form Popup -->
        <div id="addInvoiceForm" class="popup1 popup">
        <span class="close" onclick="toggleAddInvoiceForm()">&times;</span>
        <h2 style="text-align: center;">Add Invoice</h2>
        <form id="invoiceForm" action="./form-handlers/invoice-post.php" method="post">
        <div class="form-field">
                <div >
                    <label>
                        <input type="radio" name="supplierType" value="existing" onclick="toggleSupplierFields()" checked>Existing Supplier
                    </label>
                    <label>
                        <input type="radio" name="supplierType" id="newSupplierRadio" value="new" onclick="toggleSupplierFields()">New Supplier
                    </label>
                </div>

                <div class="form-field" id="supplier-name-field">
                    <label for="supplierName">Supplier Name:</label>
                    <input type="text" id="supplierNameText" name="supplierName" >
                    <select id="supplierNameDropdown" name="supplierID" >
                        <?php
                        // Fetch customer data from the database
                        $conn = new mysqli($servername, $username, $password, $database);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT Supplier_ID, Supplier_Name, Supplier_Contact_Number FROM supplier_details";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='".$row["Supplier_ID"]."'>" . $row["Supplier_Name"] . " (" . $row["Supplier_Contact_Number"] . ")</option>";
                            }
                        }

                        $conn->close();
                        ?>
                    </select>
                </div>

                <div class="form-field" id="supplier-phone-field" >
                    <label for="supplierPhone">Supplier Phone:</label>
                    <input type="text" id="supplierPhone" name="supplierPhone">
                </div>

                <div class="form-field">
                <label for="invoiceDate">Invoice Date:</label>
            <input type="date" id="invoiceDate" name="invoiceDate" required>
                </div>

                <div id="componentFieldsContainer">
                </div>
                
                <div class="form-field">
                <button type="button" onclick="addInvoiceComponent()" class="add-service-btn">Add Component</button>
                </div>

                <div class="form-field">
                    <label for="totalPrice">Total Price (RM):</label>
                    <input type="number" id="totalPrice" name="totalPrice" step="0.1" readonly required><br>
                </div>

                <div class="form-field">
                <input type="submit" value="Submit">
                </div>

            </form>
        </div>
    </div>
                    </main>
                    <div class="fixed-button-container">
            <button class="fixed-button" onclick="toggleAddInvoiceForm()">Add Invoice</button>
        </div>  


    <!-- e           d            i              t  -->
        <div id="editInvoiceForm" class="popup1 popup">
                    <span class="close" onclick="toggleEditInvoiceForm()">&times;</span>
                    <!-- Edit Service Form -->
                    <h2 style="text-align: center;">Edit Invoice</h2>
                    <form id="editInvoiceForm" action="./form-handlers/update-invoice.php" method="post">

                <div class="form-field">
                    <label>
                        <input type="radio" name="supplierType" value="existing" onclick="toggleSupplierFieldsEdit()" checked>Existing Supplier
                    </label>
                    <label>
                        <input type="radio" name="supplierType" id="editNewSupplierRadio" value="new" onclick="toggleSupplierFieldsEdit()">New Supplier
                    </label>
                </div>
                <input type="hidden" id="editInvoiceId" name="invoiceID">

                <div class="form-field" id="editSupplier-name-field">
                    <label for="supplierName">Supplier Name:</label>
                    <input type="text" id="editSupplierNameText" name="supplierName" >
                    <select id="editSupplierNameDropdown" name="supplierID" >
                        <?php
                        // Fetch customer data from the database
                        $conn = new mysqli($servername, $username, $password, $database);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT Supplier_ID, Supplier_Name, Supplier_Contact_Number FROM supplier_details";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='".$row["Supplier_ID"]."'>" . $row["Supplier_Name"] . " (" . $row["Supplier_Contact_Number"] . ")</option>";
                            }
                        }

                        $conn->close();
                        ?>
                    </select>
                </div>

                <div class="form-field" id="editSupplier-phone-field">               
                    <label for="supplierPhone">Supplier Phone:</label>
                    <input type="text" id="supplierPhone" name="supplierPhone" ><br>
                </div>

                <div class="form-field">
                    <label for="invoiceDate">Invoice Date:</label>
                    <input type="date" id="editInvoiceDate" name="invoiceDate" required><br>
                </div>

                <div id="editComponentFieldsContainer">
                </div>
                
                <div class="form-field">
            <button type="button" onclick="addInvoiceComponentWithPlaceholder()" class="add-invoice-btn">Add Component</button>

                <div class="form-field">
                    <label for="totalPrice">Total Price (RM):</label>
                    <input type="number" id="editTotalPrice" name="totalPrice" step="0.1" readonly required><br>
                </div>

                <div class="form-field">
                <input type="submit" id="editSubmitButton" value="Submit" >            </div>
                </div>

            </form>
                </div>

        <script type="text/javascript" src="../scripts/global-scripts.js"></script>
    </div>
    <script>
        // Function to toggle the sort order of the invoice date column
        function toggleSort() {
            var table = document.getElementById("invoiceTable");
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
                function addInvoiceComponentWithPlaceholder(invoiceComponentData = {}) {
            var componentAndQuantity = {};
            var componentFieldsContainer = document.getElementById("editComponentFieldsContainer");
            var numComponents = componentFieldsContainer.childElementCount;
            var totalPrice = document.getElementById("totalPrice");
            totalPrice.value = 0;
            var div = document.createElement("div");
            var label = document.createElement("label");
            label.classList.add("invoice-component-label");
            var select = document.createElement("select");
            select.name = "invoiceComponents[" + numComponents + "][existingComponentName]";
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
                    echo "option.textContent = 'No Existing Components';";
                    echo "select.appendChild(option);";
                }
                $conn->close();
            ?>

            if (Object.keys(invoiceComponentData).length > 0) {
                var defaultComponentId = invoiceComponentData["componentId"];
                var options = select.options;

                // Select the default component
                for (var i = 0; i < options.length; i++) {
                    if (options[i].value == defaultComponentId) {
                        options[i].selected = true;
                        break; // Once found, no need to continue looping
                    }
                }
            }

            var newComponentOption = document.createElement("option");
            newComponentOption.textContent = "(New Component)";
            newComponentOption.value = "new";
            select.appendChild(newComponentOption);

            var newComponentText = document.createElement("input");
            newComponentText.type = "text";
            newComponentText.name = "invoiceComponents[" + numComponents + "][newComponentName]";
            newComponentText.style.display = "none";

            select.addEventListener('change', function() {
                if (select.value === "new") {
                    select.style.display = "none";
                    select.required = false;
                    newComponentText.style.display = "inline";
                    newComponentText.required = true;
                } else {
                    select.style.display = "inline";
                    select.required = true;
                    newComponentText.style.display = "none";
                    newComponentText.required = false;
                }
                quantityInput.max = componentAndQuantity[select.value] || 1;
                calculateTotal();
            });
            select.oninput =function changeMaxQuantity(){quantityInput.max= componentAndQuantity[select.value]};

            var quantityLabel = document.createElement("label");
            quantityLabel.textContent = "Quantity:";
            var quantityInput = document.createElement("input");
            
            if (Object.keys(invoiceComponentData).length > 0) {
                quantityInput.value = invoiceComponentData["invoiceComponentQuantity"];
            }
            quantityInput.type = "number";
            quantityInput.name = "invoiceComponents[" + numComponents + "][quantity]";
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
            priceInput.name = "invoiceComponents[" + numComponents + "][pricePerPiece]";
            priceInput.step = "0.01";
            priceInput.min = "0";
            priceInput.required = true;
            priceInput.classList.add("input-field");
            priceInput.addEventListener('input', function() {
                calculateTotal();
            });

            var subTotalLabel = document.createElement("label");
            subTotalLabel.textContent = "Sub Total (RM):";
            var subTotalInput = document.createElement("input");
            subTotalInput.classList.add("subtotal");
            subTotalInput.type = "number";
            subTotalInput.step = "0.01";
            subTotalInput.value = "0";
            subTotalInput.name = "invoiceComponents[" + numComponents + "][subTotal]";
            subTotalInput.readOnly = true;

            if (Object.keys(invoiceComponentData).length > 0) {
                priceInput.value = invoiceComponentData["invoiceComponentPricePerUnit"]
                subTotalInput.value = (Math.round(quantityInput.value * priceInput.value * 100) / 100).toFixed(2);
                updateGrandTotal(false);
            }

            var removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.classList.add("input-field");
            removeButton.textContent = "Remove Component";
            removeButton.addEventListener('click', function() {
                componentFieldsContainer.removeChild(div);
                // Re-label the remaining invoice components
                var labels = componentFieldsContainer.getElementsByClassName("invoice-component-label");
                for (var i = 0; i < labels.length; i++) {
                    labels[i].innerHTML = "Invoice Component " + (i + 1) + ":";
                }
                updateGrandTotal(false);
            });

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
            priceContainer.classList.add("price-container");
            quantityContainer.classList.add("quantity-container");
            subtotalContainer.classList.add("subtotal-container");

            div.appendChild(label);
            div.appendChild(select);
            div.appendChild(newComponentText);
            div.appendChild(quantityContainer);
            div.appendChild(priceContainer);
            div.appendChild(subtotalContainer);
            div.appendChild(removeButton);
            componentFieldsContainer.appendChild(div);

            // Re-label the remaining invoice components
            var labels = componentFieldsContainer.getElementsByClassName("invoice-component-label");
            for (var i = 0; i < labels.length; i++) {
                labels[i].innerHTML = "<span style='font-weight: bold;'>Invoice Component " + (i + 1) + ":</span>";
            }

            function calculateTotal() {
                subTotalInput.value = (Math.round(quantityInput.value * priceInput.value * 100) / 100).toFixed(2);
                updateGrandTotal(false);
            }


            // Ensure the calculation is run initially if there is existing data
            calculateTotal();
        }


            // Function to add a service component
            window.onload = function() {
        document.getElementById("invoiceForm").addEventListener("submit", function(event) {
            if (!hasInvoiceComponent()) {
                event.preventDefault();
                alert("Please add at least one component before submitting the form.");
            }
        });

        document.getElementById("editInvoiceForm").addEventListener("submit", function(event) {
            if (!hasEditInvoiceComponent()) {
                event.preventDefault();
                alert("Please add at least one component before submitting the form.");
            }
        });
    };

        // Function to add a invoice component
        function addInvoiceComponent() {
            var componentAndQuantity ={}
            var componentFieldsContainer = document.getElementById("componentFieldsContainer");
            var numComponents = componentFieldsContainer.childElementCount;
            var totalPrice = document.getElementById("totalPrice");
            totalPrice.value = 0;
            var div = document.createElement("div");
            var label = document.createElement("label");
            label.classList.add("invoice-component-label")
            var select = document.createElement("select");
            select.name = "invoiceComponents[" + numComponents + "][existingComponentName]";
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
                        echo "componentAndQuantity['".$row["Component_Name"]."'] = ".$row["Component_Quantity"].";";
                    }
                }
                else{
                    echo "var option = document.createElement('option');";
                    echo "option.value = 'new';";
                    echo "option.textContent = 'No Existing Components';";
                    echo "select.appendChild(option);";
                }
                $conn->close();
            ?>

            select.oninput = function changeMaxQuantity() {
                    quantityInput.max = componentAndQuantity[select.value];
                };
            //Extra option to represent new component
            var newComponentOption = document.createElement("option");
            newComponentOption.textContent = "(New Component)";
            newComponentOption.value = "new";
            //Clicking on this new component option will hide dropdown and show textbox
            select.oninput= function changeComponentFields(){
                if (select.value=="new"){
                    select.style.display = "none";
                    select.required =false;
                    newComponentText.style.display = "inline";
                    newComponentText.required = true;
                }
            };
            select.appendChild(newComponentOption);
            var newComponentText = document.createElement("input");
            newComponentText.type = "text";
            newComponentText.name = "invoiceComponents[" + numComponents + "][newComponentName]";
            newComponentText.style.display = "none";
            var quantityLabel = document.createElement("label");
            quantityLabel.textContent = "Quantity:";
            var quantityInput = document.createElement("input");
            quantityInput.type = "number";
            quantityInput.name = "invoiceComponents[" + numComponents + "][quantity]";
            quantityInput.min = "1";
            quantityInput.step = "1";
            quantityInput.required = true;
            quantityInput.classList.add("input-field");
            quantityInput.oninput = function calculateTotal(){
                subTotalInput.value=(Math.round(quantityInput.value * priceInput.value * 100) / 100).toFixed(2);
                updateGrandTotal(true)
            };
            quantityInput.max = componentAndQuantity[select.value];

            var priceLabel = document.createElement("label");
            priceLabel.textContent = "Price per piece (RM):";

            var priceInput = document.createElement("input");
            priceInput.type = "number";
            priceInput.name = "invoiceComponents[" + numComponents + "][pricePerPiece]";
            priceInput.step = "0.01";
            priceInput.min = "0";
            priceInput.required = true;
            priceInput.classList.add("input-field"); 
            priceInput.oninput = function calculateTotal(){
                subTotalInput.value=(Math.round(quantityInput.value * priceInput.value * 100) / 100).toFixed(2);
                updateGrandTotal(true)
            };

            var subTotalLabel = document.createElement("label");
            subTotalLabel.textContent = "Sub Total (RM):";

            var subTotalInput = document.createElement("input");
            subTotalInput.classList.add("subtotal");
            subTotalInput.type = "number";
            subTotalInput.step = "0.01";
            subTotalInput.value = "0";
            subTotalInput.name = "invoiceComponents[" + numComponents + "][subTotal]";
            subTotalInput.readOnly = true;
            var removeButton = document.createElement("button");
            removeButton.type = "button";
            subTotalInput.classList.add("input-field");
            removeButton.textContent = "Remove Component";
            removeButton.onclick = function() {
                componentFieldsContainer.removeChild(div);
                // Re-label the remaining invoice components
                var labels = componentFieldsContainer.getElementsByClassName("invoice-component-label");
                for (var i = 0; i < labels.length; i++) {
                    labels[i].innerHTML = "Invoice Component " + (i+1) + ":";
                }
                updateGrandTotal(true)
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
            div.appendChild(newComponentText);
            div.appendChild(quantityContainer);
            div.appendChild(priceContainer); 
            div.appendChild(subtotalContainer);
            div.appendChild(removeButton);
            componentFieldsContainer.appendChild(div);
            // Re-label the remaining invoice components
            var labels = componentFieldsContainer.getElementsByClassName("invoice-component-label");
            for (var i = 0; i < labels.length; i++) {
                labels[i].innerHTML = "<span style='font-weight: bold;'>Invoice Component " + (i+1) + ":</span>";
            }
            updateGrandTotal(true)
        }

        function hasInvoiceComponent() {
            var componentFieldsContainer = document.getElementById("componentFieldsContainer");
            var childrenPresent = componentFieldsContainer.childElementCount > 0;
            return childrenPresent;
        }

        function hasEditInvoiceComponent() {
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
                document.getElementById("invoiceForm").insertBefore(messageElement, document.getElementById("invoiceForm").firstChild);
            }
            messageElement.textContent = message;
        }

        function toggleSupplierFieldsEdit() {
            var newSupplierRadio = document.getElementById("editNewSupplierRadio");
            var supplierNameDropdown = document.getElementById("editSupplierNameDropdown");
            var supplierNameText = document.getElementById("editSupplierNameText");
            var supplierPhoneField= document.getElementById("editSupplier-phone-field");

            if (!newSupplierRadio.checked) {
                supplierNameDropdown.style.display = "block";
                supplierNameDropdown.required = true;
                supplierNameText.style.display = "none";
                supplierNameText.required = false;
                supplierPhoneField.style.display = "none";
                supplierPhoneField.required = false;
                
            } else {
                supplierNameDropdown.style.display = "none";
                supplierNameDropdown.required = false;
                supplierNameText.style.display = "block";
                supplierNameText.required = true;
                supplierPhoneField.style.display = "block";
                supplierPhoneField.required = true;

            }
        }
        toggleSupplierFieldsEdit()
        
        function toggleSupplierFields() {
            var newSupplierRadio = document.getElementById("newSupplierRadio");
            var supplierNameDropdown = document.getElementById("supplierNameDropdown");
            var supplierNameText = document.getElementById("supplierNameText");
            var supplierPhoneField= document.getElementById("supplier-phone-field");

            if (!newSupplierRadio.checked) {
                supplierNameDropdown.style.display = "block";
                supplierNameDropdown.required = true;
                supplierNameText.style.display = "none";
                supplierNameText.required = false;
                supplierPhoneField.style.display = "none";
                supplierPhoneField.required = false;
                
            } else {
                supplierNameDropdown.style.display = "none";
                supplierNameDropdown.required = false;
                supplierNameText.style.display = "block";
                supplierNameText.required = true;
                supplierPhoneField.style.display = "block";
                supplierPhoneField.required = true;

            }
        }

        addInvoiceComponent();
        toggleSupplierFields();

        //When document is ready
        $(document).ready(function () {
            var isOpen = false; 
            //If More Details button is clicked, toggle popup
            $(".more").click(function (e) {
                if(isOpen){
                    closePopup();
                }else{
                    e.preventDefault();
                    invoiceId = $(this).data("id")
                    openPopup(invoiceId);
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

            function openPopup(invoiceId) {
                isOpen = true;
                $.ajax({
                    type: "POST",
                    url: "./form-handlers/ordered-component-ajax.php",
                    data: { 'id': invoiceId },
                    success: function(response) {
                        // Handle the response from PHP here
                        $("div.popup2 tbody").html(response);
                        $("div.popup2").fadeIn();
                        $(".popup2").find("h2:last").remove();
                        $(".popup2").append("<h2>TOTAL PRICE: RM" + $("#total"+invoiceId).text() +"</h2>")
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
            var invoiceId = button.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this invoice?')) {
                // Send delete request to the backend using fetch or XMLHttpRequest
                fetch('delete-handlers/delete-invoice.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'invoiceId=' + encodeURIComponent(invoiceId),
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
                        // For example, reload the page or remove the deleted invoice row
                        location.reload();
                    } else {
                        // Show error message on the page
                        alert(data.message);
                    }
                })
                .catch(function (error) {
                    console.error('Error:', error);
                    alert('Error deleting invoice.');
                });
            }
        });
    });
});
function toggleAddInvoiceForm() {
            var addInvoiceForm = document.getElementById('addInvoiceForm');
            addInvoiceForm.classList.toggle('display');
        }

        function adjustRowSpacing() {
        const tableRows = document.querySelectorAll("#invoiceTable tbody tr");
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
                var invoiceId = button.getAttribute('data-id');
                // Show the edit form and fill it with service data
                showInvoiceEditForm(invoiceId);
            });
        });
    });

    function jsonToArrayOfObjects(jsonObj) {
        return Object.keys(jsonObj).map(key => jsonObj[key]);
    }

    function showInvoiceEditForm(invoiceId) {
    var componentFieldsContainer = document.getElementById("editComponentFieldsContainer");
    while (componentFieldsContainer.firstChild) {
        componentFieldsContainer.removeChild(componentFieldsContainer.firstChild);
    }
    // Fetch service data using AJAX
    fetch('get-invoice.php?id=' + encodeURIComponent(invoiceId))
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            // Fill edit form fields with service data
            document.getElementById("editInvoiceDate").value = data.row0.invoiceDate;
            console.log("asd")
            document.getElementById("editInvoiceId").value = data.row0.invoiceId;
            var supplierNameDropdown = document.getElementById("editSupplierNameDropdown");
            var options = supplierNameDropdown.options;
            for (var i = 0; i < options.length; i++) {
                if (options[i].value == data.row0.supplierId) {
                    options[i].selected = true;
                    console.log(options[i].value);
                    break; // Once found, no need to continue looping
                }
            }

            const arrayOfObjects = jsonToArrayOfObjects(data);
            for (let i = 0; i < arrayOfObjects.length; i++) {
                let row = arrayOfObjects[i.toString()];
                addInvoiceComponentWithPlaceholder(invoiceComponentData = row);
            }
            updateGrandTotal(false);
            // TO DO: Handle Service Component
            // Show the edit form popup/modal
            toggleEditInvoiceForm();
        })
        .catch(function (error) {
            console.error('Error fetching invoice data:', error);
            alert('Error fetching invoice data. Please try again.', error);
        });
}

    // Function to toggle display of edit service form
    function toggleEditInvoiceForm() {
        var editPopup = document.getElementById("editInvoiceForm");
        editPopup.classList.toggle("display");
    }

    // Function to handle edit button click
function handleEdit(invoiceId) {
    // Send AJAX request to fetch service data
    $.ajax({
        url: 'fetch-invoice.php', // Replace with your PHP script to fetch service data
        method: 'GET',  
        data: { invoiceId: invoiceId },
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
    document.getElementById('editSupplierNameText').value = invoice.supplierName;
    document.getElementById('editSupplierPhone').value = invoice.supplierPhone;
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
            table = document.getElementById("invoiceTable");
            tr = table.getElementsByTagName("tr");
            startDateInput = document.getElementById("startDateInput").value;
            endDateInput = document.getElementById("endDateInput").value;

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2]; // Change index based on the column where customer name is located
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