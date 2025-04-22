<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Orders</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierCompletedOrders.css">
    
</head>
<body>
<?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>
<div class="payments-container">
    <h2>Completed Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Address</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['completedOrders'])): ?>
            <?php foreach ($data['completedOrders'] as $order): ?>
                <tr>
                    <td><?php echo $order->order_id; ?></td>
                    <td><?php echo $order->customer_id; ?></td>
                    <td>
                        <?php if (!empty($order->items) && is_array($order->items)): ?>
                            <div class="item-details">
                                <ul>
                                    <?php foreach ($order->items as $item): ?>
                                        <li>
                                            <div class="item-attribute">
                                                <strong>Item</strong>
                                                <span><?php echo $item->item_name; ?></span>
                                            </div>
                                            <div class="item-attribute">
                                                <strong>Qty</strong>
                                                <span><?php echo $item->quantity; ?></span>
                                            </div>
                                            <div class="item-attribute">
                                                <strong>Price</strong>
                                                <span><?php echo number_format($item->price, 2); ?></span>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php else: ?>
                            <div class="item-details">No items found</div>
                        <?php endif; ?>
                    </td>
                    <td><?php echo number_format($order->total_amount, 2); ?></td>
                    <td>
                        <span class="payment-method" style="background: <?php echo $order->payment_method === 'credit_card' ? '#e6f4ea' : '#ebf8ff' ?>; color: <?php echo $order->payment_method === 'credit_card' ? '#137333' : '#2b6cb0' ?>;">
                            <?php echo str_replace('_', ' ', $order->payment_method); ?>
                        </span>
                    </td>
                    <td><?php echo substr($order->delivery_address, 0, 30) . '...'; ?></td>
                    <td><?php echo date('M j, Y', strtotime($order->created_at)); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No completed orders available</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>