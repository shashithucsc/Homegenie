<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Orders</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <style>
        /* Base Colors */
        :root {
            --primary-color: #4a6cf7;
            --secondary-color: #6a7aff;
            --background-color: #f4f7ff;
            --text-color: #333;
            --button-hover-color: #3a5bf1;
            --border-radius: 8px;
        }

        /* General Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
        }

        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 20px;
        }

        .payments-container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-left: 280px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: var(--primary-color);
            color: white;
        }

        td {
            background-color: #fff;
            color: var(--text-color);
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
        }

        .action-buttons button {
            padding: 12px 20px;
            border: none;
            border-radius: var(--border-radius);
            font-size: 0.95rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .accept-btn {
            background-color: rgb(241, 0, 0);
            color: white;
        }

        .accept-btn:hover {
            background-color: var(--button-hover-color);
        }

        .cancel-btn {
            background-color: var(--secondary-color);
            color: white;
        }

        .cancel-btn:hover {
            background-color: #4d61f7;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                font-size: 0.85rem;
            }

            th, td {
                padding: 10px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .accept-btn, .cancel-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<?php require APPROOT . '/views/admin/sidebar.php'; ?>
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
                        <ul>
                            <li>Item ID: <?php echo $order->item_id; ?></li>
                            <li>Quantity: <?php echo $order->quantity; ?></li>
                            <li>Price: <?php echo $order->price; ?></li>
                        </ul>
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
