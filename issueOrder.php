<?php
require_once 'php_action/db_connect.php';

if ($_POST) {
    $orderId = $_POST['orderId'];

    // Fetch order items
    $orderItemSql = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $connect->prepare($orderItemSql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orderItemResult = $stmt->get_result();

    while ($orderItemData = $orderItemResult->fetch_array()) {
        $productId = $orderItemData['product_id'];
        $quantity = $orderItemData['quantity'];

        // Update product quantity in stock
        $updateProductSql = "UPDATE product SET quantity = quantity - ? WHERE product_id = ?";
        $updateStmt = $connect->prepare($updateProductSql);
        $updateStmt->bind_param("ii", $quantity, $productId);
        $updateStmt->execute();
    }

    // Update order status to issued
    $updateOrderSql = "UPDATE orders SET status = 0 WHERE order_id = ?";
    $updateStmt = $connect->prepare($updateOrderSql);
    $updateStmt->bind_param("i", $orderId);
    if ($updateStmt->execute()) {
        echo json_encode(array("success" => true, "message" => "Order has been issued successfully."));
    } else {
        echo json_encode(array("success" => false, "message" => "Error while issuing order."));
    }

    $connect->close();
}
?>