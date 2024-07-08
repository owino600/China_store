<?php
require_once 'php_action/db_connect.php'; // Include your database connection file
<?php require_once 'includes/header.php'; ?>

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['orderId'];

    // Begin transaction
    mysqli_begin_transaction($connect);

    try {
        // Get all products and quantities for the order
        $query = "SELECT product_id, quantity FROM order_item WHERE order_id = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Loop through each product in the order and update the product quantities
        while ($row = $result->fetch_assoc()) {
            $productId = $row['product_id'];
            $quantity = $row['quantity'];

            // Update product quantity
            $updateQuery = "UPDATE product SET quantity = quantity - ? WHERE product_id = ?";
            $updateStmt = $connect->prepare($updateQuery);
            $updateStmt->bind_param("ii", $quantity, $productId);
            $updateStmt->execute();
        }

        // Delete the order from orders table
        $deleteOrderQuery = "DELETE FROM orders WHERE order_id = ?";
        $deleteOrderStmt = $connect->prepare($deleteOrderQuery);
        $deleteOrderStmt->bind_param("i", $orderId);
        $deleteOrderStmt->execute();

        // Delete the order items from order_item table
        $deleteOrderItemQuery = "DELETE FROM order_item WHERE order_id = ?";
        $deleteOrderItemStmt = $connect->prepare($deleteOrderItemQuery);
        $deleteOrderItemStmt->bind_param("i", $orderId);
        $deleteOrderItemStmt->execute();

        // Commit transaction
        mysqli_commit($connect);

        $response = array('success' => true, 'message' => 'Order issued successfully.');
    } catch (Exception $e) {
        // Rollback transaction in case of error
        mysqli_rollback($connect);
        $response = array('success' => false, 'message' => 'Error issuing order: ' . $e->getMessage());
    }

    echo json_encode($response);
}
?>
