<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Orders</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierPendingOrders.css">
    
</head>
<body>
<?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>
<div class="payments-container">
    <h2>Pending Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Items Details</th>
                <th>Total Amount</th>
                <th>Payment Method</th>
                <th>Delivery Address</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['pendingOrders'])): ?>
            <?php foreach ($data['pendingOrders'] as $order): ?>
                <tr>
                    <td><?php echo $order->order_id; ?></td>
                    <td><?php echo $order->customer_id; ?></td>
                    <td>
                        <!-- Display Items Details in a list -->
                        <?php if (!empty($order->items) && is_array($order->items)): ?>
                            <ul>
                                <?php foreach ($order->items as $item): ?>
                                    <li>
                                        <strong>Item Name:</strong> <?php echo $item->item_name; ?><br>
                                        <strong>Item ID:</strong> <?php echo $item->item_id; ?><br>
                                        <strong>Quantity:</strong> <?php echo $item->quantity; ?><br>
                                        <strong>Price:</strong> <?php echo $item->price; ?><br><br>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No items found.</p>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $order->total_amount; ?></td>
                    <td><?php echo $order->payment_method; ?></td>
                    <td><?php echo $order->delivery_address; ?></td>
                    <td><?php echo $order->created_at; ?></td>
                    <td>
                        <div class="action-buttons">
                            <form action="<?php echo URLROOT; ?>/SupplierController/updateOrderStatus" method="POST">
                                <input type="hidden" name="order_id" value="<?php echo $order->order_id; ?>">
                                <input type="hidden" name="status" value="Accepted">
                                <button type="submit" class="accept-btn">Accept</button>
                            </form>
                            <form action="<?php echo URLROOT; ?>/SupplierController/updateOrderStatus" method="POST">
                                <input type="hidden" name="order_id" value="<?php echo $order->order_id; ?>">
                                <input type="hidden" name="status" value="Rejected">
                                <button type="submit" class="cancel-btn">Cancel</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align: center;">No pending orders available.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
