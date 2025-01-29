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
            background-color:rgb(172, 52, 52);
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
<?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>
<div class="payments-container">
    <h2>Completed Orders</h2>
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
               
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['completedOrders'])): ?>
            <?php foreach ($data['completedOrders'] as $order): ?>
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
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align: center;">No Completed orders available.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
