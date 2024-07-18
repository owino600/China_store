<?php
require_once 'core.php';

if ($_POST) {
    $orderId = $_POST['orderId'];
    $valid = array('success' => false, 'message' => '');

    // Begin transaction
    $connect->begin_transaction();

    try {
        // Get order items
        $sql = "SELECT product_id, quantity FROM order_item WHERE order_id = ?";
        $stmt = $connect->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Prepare statement failed: ' . $connect->error);
        }
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productId = $row['product_id'];
                $quantity = $row['quantity'];

                // Update product quantity
                $updateProductSql = "UPDATE product SET quantity = quantity - ? WHERE product_id = ?";
                $updateStmt = $connect->prepare($updateProductSql);
                if ($updateStmt === false) {
                    throw new Exception('Prepare statement failed: ' . $connect->error);
                }
                $updateStmt->bind_param('ii', $quantity, $productId);
                $updateStmt->execute();
            }

            // Delete order items
            $deleteOrderItemSql = "DELETE FROM order_item WHERE order_id = ?";
            $deleteOrderItemStmt = $connect->prepare($deleteOrderItemSql);
            if ($deleteOrderItemStmt === false) {
                throw new Exception('Prepare statement failed: ' . $connect->error);
            }
            $deleteOrderItemStmt->bind_param('i', $orderId);
            $deleteOrderItemStmt->execute();

            // Delete order
            $deleteOrderSql = "DELETE FROM orders WHERE order_id = ?";
            $deleteOrderStmt = $connect->prepare($deleteOrderSql);
            if ($deleteOrderStmt === false) {
                throw new Exception('Prepare statement failed: ' . $connect->error);
            }
            $deleteOrderStmt->bind_param('i', $orderId);
            $deleteOrderStmt->execute();

            // Commit transaction
            $connect->commit();
            $valid['success'] = true;
            $valid['message'] = 'Order has been successfully issued.';
        } else {
            throw new Exception('Order not found.');
        }

    } catch (Exception $e) {
        // Rollback transaction
        $connect->rollback();
        $valid['success'] = false;
        $valid['message'] = 'Error while issuing the order: ' . $e->getMessage();
    }

    $connect->close();

    echo json_encode($valid);
}
?>