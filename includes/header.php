<?php 
require_once 'php_action/core.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock Management System</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
    <!-- bootstrap theme -->
    <link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="custom/css/custom.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css">
    <!-- file input -->
    <link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">
    <!-- jquery -->
    <script src="assests/jquery/jquery.min.js"></script>
    <!-- jquery ui -->
    <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
    <script src="assests/jquery-ui/jquery-ui.min.js"></script>
    <!-- bootstrap js -->
    <script src="assests/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">      
                <ul class="nav navbar-nav navbar-right">        
                    <li id="navDashboard"><a href="index.php"><i class="glyphicon glyphicon-list-alt"></i> Dashboard</a></li>
                    <li id="navBrand"><a href="brand.php"><i class="glyphicon glyphicon-btc"></i> Brand</a></li>
                    <li id="navCategories"><a href="categories.php"><i class="glyphicon glyphicon-th-list"></i> Category</a></li>
                    <li id="navProduct"><a href="product.php"><i class="glyphicon glyphicon-ruble"></i> Product</a></li>
                    <li class="dropdown" id="navOrder">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="glyphicon glyphicon-shopping-cart"></i> Orders <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">            
                            <li id="topNavAddOrder"><a href="orders.php?o=add"><i class="glyphicon glyphicon-plus"></i> Add Orders</a></li>            
                            <li id="topNavManageOrder"><a href="orders.php?o=manord"><i class="glyphicon glyphicon-edit"></i> Manage Orders</a></li>
                            <li id="topNavIssueOrder"><a href="issueOrder.php"><i class="glyphicon glyphicon-wrench"></i> Issue Request</a></li>            
                        </ul>
                    </li> 
                    <li id="navReport"><a href="report.php"><i class="glyphicon glyphicon-check"></i> Report</a></li>
                    <li class="dropdown" id="navSetting">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="glyphicon glyphicon-user"></i> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">            
                            <li id="topNavSetting"><a href="setting.php"><i class="glyphicon glyphicon-wrench"></i> Setting</a></li>
                            <li id="topNavLogout"><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                        </ul>
                    </li>        
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Your content goes here -->

        <!-- Example table row with issue button -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>123</td>
                    <td>Product 1</td>
                    <td>10</td>
                    <td><button class="issue-btn btn btn-primary" data-order-id="123">Issue Order</button></td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('.issue-btn').on('click', function() {
                var orderId = $(this).data('order-id');
                $.ajax({
                    url: 'php_action/issueOrder.php', // Ensure this path is correct
                    type: 'POST',
                    data: { orderId: orderId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success === true) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error: ' + status + ' - ' + error);
                        alert('An error occurred while issuing the order. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>