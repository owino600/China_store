<?php
require_once 'php_action/db_connect.php';

if ($_POST) {
    $orderId = $_POST['orderId'];

    // Fetch order items
    $orderItemSql = "SELECT * FROM order_item WHERE order_id = {$orderId}";
    $orderItemResult = $connect->query($orderItemSql);

    while ($orderItemData = $orderItemResult->fetch_array()) {
        $productId = $orderItemData['product_id'];
        $quantity = $orderItemData['quantity'];

        // Update product quantity in stock
        $updateProductSql = "UPDATE product SET quantity = quantity - {$quantity} WHERE product_id = {$productId}";
        $connect->query($updateProductSql);
    }

    // Update order status to issued
    $updateOrderSql = "UPDATE orders SET status = 0 WHERE order_id = {$orderId}";
    if ($connect->query($updateOrderSql) === TRUE) {
        echo json_encode(array("success" => true, "message" => "Order has been issued successfully."));
    } else {
        echo json_encode(array("success" => false, "message" => "Error while issuing order."));
    }

    $connect->close();
}
?>