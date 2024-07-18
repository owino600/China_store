<?php 
require_once 'php_action/db_connect.php'; 
require_once 'includes/header.php'; 

if($_GET['o'] == 'add') { 
    // add order
    echo "<div class='div-request div-hide'>add</div>";
} else if($_GET['o'] == 'manord') { 
    // manage order
    echo "<div class='div-request div-hide'>manord</div>";
} else if($_GET['o'] == 'editOrd') { 
    // edit order
    echo "<div class='div-request div-hide'>editOrd</div>";
} else if($_GET['o'] == 'issuereq') {
    // Issue Request
    echo "<div class='div-request div-hide'>issuereq</div>";
} // /else manage order
?>

<ol class="breadcrumb">
    <li><a href="dashboard.php">Home</a></li>
    <li>Order</li>
    <?php if($_GET['o'] == 'add') { ?>
        <li class="active">Add Order</li>
    <?php } else if($_GET['o'] == 'manord') { ?>
        <li class="active">Manage Order</li>
    <?php } else if($_GET['o'] == 'editOrd') { ?>
        <li class="active">Edit Order</li>
    <?php } else if($_GET['o'] == 'issuereq') { ?>
        <li class="active">Issue Request</li>
    <?php } ?>
</ol>

<h4>
    <i class='glyphicon glyphicon-circle-arrow-right'></i>
    <?php if($_GET['o'] == 'add') {
        echo "Add Order";
    } else if($_GET['o'] == 'manord') { 
        echo "Manage Order";
    } else if($_GET['o'] == 'editOrd') { 
        echo "Edit Order";
    } else if($_GET['o'] == 'issuereq') {
        echo "Issue Request";
    }
    ?>  
</h4>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php if($_GET['o'] == 'add') { ?>
            <i class="glyphicon glyphicon-plus-sign"></i> Add Order
        <?php } else if($_GET['o'] == 'manord') { ?>
            <i class="glyphicon glyphicon-edit"></i> Manage Order
        <?php } else if($_GET['o'] == 'editOrd') { ?>
            <i class="glyphicon glyphicon-edit"></i> Edit Order
        <?php } else if($_GET['o'] == 'issuereq') { ?>
            <i class="glyphicon glyphicon-edit"></i> Issue Request
        <?php } ?>
    </div>
    <div class="panel-body">
        <?php if($_GET['o'] == 'add') { 
            // add order
            ?>
            <!-- Add Order Form -->
            <form class="form-horizontal" method="POST" action="php_action/createOrder.php" id="createOrderForm">
                <!-- Form elements for creating order -->
            </form>
        <?php } else if($_GET['o'] == 'manord') { 
            // manage order
            ?>
            <!-- Manage Order Table -->
            <table class="table" id="manageOrderTable">
                <!-- Table elements for managing order -->
            </table>
        <?php } else if($_GET['o'] == 'editOrd') { 
            // edit order
            ?>
            <!-- Edit Order Form -->
            <form class="form-horizontal" method="POST" action="php_action/editOrder.php" id="editOrderForm">
                <!-- Form elements for editing order -->
            </form>
        <?php } else if($_GET['o'] == 'issuereq') { 
            // issue request
            ?>
            <!-- Issue Request Form -->
            <form class="form-horizontal" method="POST" action="php_action/issueRequest.php" id="issueRequestForm">
                <!-- Form elements for issuing request -->
                <div class="form-group">
                    <label for="requestDate" class="col-sm-2 control-label">Request Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="requestDate" name="requestDate" autocomplete="off" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="requesterName" class="col-sm-2 control-label">Requester Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="requesterName" name="requesterName" placeholder="Requester Name" autocomplete="off" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="requesterContact" class="col-sm-2 control-label">Requester Contact</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="requesterContact" name="requesterContact" placeholder="Contact Number" autocomplete="off" />
                    </div>
                </div>
                <table class="table" id="productTable">
                    <thead>
                        <tr>
                            <th style="width:40%;">Product</th>
                            <th style="width:20%;">Rate</th>
                            <th style="width:15%;">Quantity</th>
                            <th style="width:15%;">Total</th>
                            <th style="width:10%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $orderId = $_GET['i'];
                        $orderItemSql = "SELECT order_item.order_item_id, order_item.order_id, order_item.product_id, order_item.quantity, order_item.rate, order_item.total FROM order_item WHERE order_item.order_id = {$orderId}";
                        $orderItemResult = $connect->query($orderItemSql);
                        $arrayNumber = 0;
                        $x = 1;
                        while($orderItemData = $orderItemResult->fetch_array()) { ?>
                            <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">                              
                                <td style="margin-left:20px;">
                                    <div class="form-group">
                                        <select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
                                            <option value="">~~SELECT~~</option>
                                            <?php
                                            $productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
                                            $productData = $connect->query($productSql);
                                            while($row = $productData->fetch_array()) {
                                                $selected = "";
                                                if($row['product_id'] == $orderItemData['product_id']) {
                                                    $selected = "selected";
                                                }
                                                echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."' ".$selected." >".$row['product_name']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                                <td style="padding-left:20px;">
                                    <input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />
                                    <input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />
                                </td>
                                <td style="padding-left:20px;">
                                    <div class="form-group">
                                        <input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" value="<?php echo $orderItemData['quantity']; ?>" />
                                    </div>
                                </td>
                                <td style="padding-left:20px;">
                                    <input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" value="<?php echo $orderItemData['total']; ?>"/>
                                    <input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['total']; ?>"/>
                                </td>
                                <td>
                                    <button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                                </td>
                            </tr>
                        <?php
                        $arrayNumber++;
                        $x++;
                        } ?>
                    </tbody>
                </table>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
                            <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
                        </div>
                    </div> <!--/form-group-->                
                    <div class="form-group">
                        <label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true"/>
                            <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
                        </div>
                    </div> <!--/form-group-->
                    <div class="form-group">
                        <label for="discount" class="col-sm-3 control-label">Discount</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" />
                        </div>
                    </div> <!--/form-group-->
                    <div class="form-group">
                        <label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" />
                            <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" />
                        </div>
                    </div> <!--/form-group-->                
                </div> <!--/col-md-6-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="paid" class="col-sm-3 control-label">Paid Amount</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="paid" name="paid" onkeyup="paidAmount()" autocomplete="off" />
                        </div>
                    </div> <!--/form-group-->        
                    <div class="form-group">
                        <label for="due" class="col-sm-3 control-label">Due Amount</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="due" name="due" disabled="true" />
                            <input type="hidden" class="form-control" id="dueValue" name="dueValue" />
                        </div>
                    </div> <!--/form-group-->
                </div> <!--/col-md-6-->
                <div class="form-group submitButtonFooter">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>
                        <button type="submit" id="createOrderBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
                        <button type="reset" class="btn btn-default" onclick="resetOrderForm()"><i class="glyphicon glyphicon-erase"></i> Reset</button>
                    </div>
                </div>
            </form>
        <?php } ?>
    </div> <!--/panel-body-->
</div> <!--/panel-->
<script src="custom/js/order.js"></script>
<?php require_once 'includes/footer.php'; ?>