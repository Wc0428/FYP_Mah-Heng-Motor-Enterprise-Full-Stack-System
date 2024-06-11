<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['componentId'])) {
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "mah heng motor database";
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die(json_encode(array('success' => false, 'message' => 'Connection failed: ' . $conn->connect_error)));
    }

    $componentId = $_POST['componentId'];

    // 检查库存数量是否为零，如果不为零则禁止删除
    $checkQuantityQuery = "SELECT Component_Quantity FROM component WHERE Component_ID = $componentId";
    $result = $conn->query($checkQuantityQuery);

    if ($result && $row = $result->fetch_assoc()) {
        $quantity = (int)$row['Component_Quantity'];
        if ($quantity > 0) {
            echo json_encode(array('success' => false, 'message' => 'Cannot delete component with quantity greater than zero.'));
        } else {
            // 执行删除操作
            $deleteQuery = "DELETE FROM component WHERE Component_ID = $componentId";
            if ($conn->query($deleteQuery) === TRUE) {
                echo json_encode(array('success' => true, 'message' => 'Component deleted successfully!'));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error deleting component: ' . $conn->error));
            }
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error fetching component quantity.'));
    }

    $conn->close();
} else {
    die(json_encode(array('success' => false, 'message' => 'Invalid request!')));
}
?>
