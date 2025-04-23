<!DOCTYPE html>
<html lang="en">
    <?php require_once APPROOT . '/views/supplier/navbar/navbar.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders- HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierCart.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
</head>
<body>
<main>
    <div class="cart-container">
        <h1>My Orders</h1>

        <?php if (!empty($data['orders'])): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Amount</th>
                        <th>Payment</th>
                        <th>Delivery Address</th>
                        <th>Order placed Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['orders'] as $order): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($order->id); ?></td>
                            <td>Rs. <?php echo number_format($order->total_amount, 2); ?></td>
                            <td><?php echo htmlspecialchars($order->payment_method); ?></td>
                            <td><?php echo htmlspecialchars($order->delivery_address); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($order->created_at)); ?></td>
                            <td>
    <?php
        $status = strtolower($order->status);
        $badgeClass = 'status-badge ';
        switch ($status) {
            case 'completed':
                $badgeClass .= 'status-completed';
                break;
            case 'cancelled':
                $badgeClass .= 'status-cancelled';
                break;
            case 'pending':
                $badgeClass .= 'status-pending';
                break;
            case 'accepted':
                $badgeClass .= 'status-accepted';
                break;
            default:
                $badgeClass = ''; 
        }
    ?>
    <span class="<?php echo $badgeClass; ?>"><?php echo htmlspecialchars($order->status); ?></span>
</td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-cart">
                <i class="fas fa-box-open"></i>
                <p>You have no orders yet.</p>
                <a href="<?php echo URLROOT; ?>/StorePageController/index" class="continue-shopping">Start Shopping</a>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php require_once APPROOT . '/views/footer.php'; ?>
</body>
</html>
