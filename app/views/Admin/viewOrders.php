<?php

$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; 
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png'; 
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

require_once APPROOT . '/views/Admin/AdminSideBar.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/AdminManageUsers.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>View Orders</title>

</head>

<body>
    <section class="main">
        <div class="top">
            <div class="welcome">
                <span class="text">
                    <h3>View Orders</h3>
                </span>
            </div>
            <div class="time" id="clock">
            </div>
        </div>
        <div class="table" id="customers_table">
            <section class="table-header">
                <h1>Orders</h1>
                <div class="input-group">
                    <input type="search" placeholder="Search ..." id="searchInput">
                    <i class='bx bx-search'></i>
                </div>
            </section>
            <section class="table-body">
                <table>
                    <thead>
                        <tr>
                            <th> Order Id </th>
                            <th> Customer ID </th>
                            <th> Supplier ID </th>
                            <th> Total </th>
                            <th> Payment Method </th>
                            <th> Delivery Address </th>
                            <th> Status </th>
                            <th> Timestamp </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($data['orders']) && count($data['orders']) > 0) : ?>
                            <?php foreach($data['orders'] as $order) : ?> 
                                <tr>
                                    <td><?php echo $order->id; ?></td>
                                    <td><?php echo $order->customer_id; ?></td>
                                    <td><?php echo $order->supplier_id; ?></td>
                                    <td><?php echo $order->total_amount; ?></td>
                                    <td><?php echo $order->payment_method; ?></td>
                                    <td><?php echo $order->delivery_address; ?></td>
                                    <td><?php echo $order->status; ?></td>
                                    <td><?php echo $order->created_at; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan='8'>No data found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </section>
    <script src="<?php echo URLROOT; ?>/public/js/clock.js"></script>
    <script src="<?php echo URLROOT; ?>/public/js/script-users.js"></script>
</body>

</html>