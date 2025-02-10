<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Orders</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <style>
        /* Base Colors */
        :root {
            --primary-color: #4a6cf7;
            --secondary-color: #6a7aff;
            --background-color: #f4f7ff;
            --text-color: #333;
            --accent-color:rgb(255, 255, 255);
            --hover-color: #3a5bf1;
            --white-color: #fff;
            --light-grey: #f9f9f9;
            --border-radius: 10px;
            --item-header-color: #333;
            --item-bg-color: #f8f8f8;
            --item-border-color: #ddd;
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
            margin-bottom: 30px;
            font-size: 1.5rem;
        }

        .payments-container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            background-color: var(--white-color);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            margin-left: 280px;
            overflow-x: auto;
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
            font-size: 1rem;
        }

        th {
            background-color: var(--primary-color);
            color: var(--white-color);
        }

        td {
            background-color: var(--white-color);
            color: var(--text-color);
        }

        tr:nth-child(even) {
            background-color: var(--light-grey);
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
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .accept-btn {
            background-color: rgb(241, 0, 0);
            color: var(--white-color);
        }

        .accept-btn:hover {
            background-color: rgb(172, 52, 52);
        }

        .cancel-btn {
            background-color: var(--secondary-color);
            color: var(--white-color);
        }

        .cancel-btn:hover {
            background-color: #4d61f7;
        }

        .item-details {
           
            border-radius: var(--border-radius);
            padding: 20px;
            margin-top: 15px;
            color: rgb(0, 0, 0);
           
        }

        .item-details ul {
            list-style-type: none;
            padding: 0;
        }

        .item-details li {
            padding: 12px 0;
            border-bottom: 1px solid var(--item-border-color);
        }

        .item-details li:last-child {
            border-bottom: none;
        }

        .item-details strong {
            font-weight: bold;
            color: var(--item-header-color);
        }

        .item-details .item-attribute {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .item-details .item-attribute span {
            font-size: 0.9rem;
            color: var(--text-color);
            text-align: right;
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
                        <!-- Display Items Details in a more structured and colorful way -->
                        <?php if (!empty($order->items) && is_array($order->items)): ?>
                            <div class="item-details">
                                <ul>
                                    <?php foreach ($order->items as $item): ?>
                                        <li>
                                            <div class="item-attribute">
                                                <strong>Item Name:</strong>
                                                <span><?php echo $item->item_name; ?></span>
                                            </div>
                                            <div class="item-attribute">
                                                <strong>Item ID:</strong>
                                                <span><?php echo $item->item_id; ?></span>
                                            </div>
                                            <div class="item-attribute">
                                                <strong>Quantity:</strong>
                                                <span><?php echo $item->quantity; ?></span>
                                            </div>
                                            <div class="item-attribute">
                                                <strong>Price:</strong>
                                                <span><?php echo $item->price; ?></span>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php else: ?>
                            <p>No items found.</p>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $order->total_amount; ?></td>
                    <td><?php echo $order->payment_method; ?></td>
                    <td><?php echo $order->delivery_address; ?></td>
                    <td><?php echo $order->created_at; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align: center;">No Completed orders available.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
