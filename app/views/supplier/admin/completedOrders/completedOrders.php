<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Orders</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <style>
        /* Modern Color Scheme */
        :root {
            --primary-color: #2a3f9d;
            --secondary-color: #4a5fc1;
            --background-color: #f8f9ff;
            --text-color: #2d3748;
            --accent-color: #e2e8f0;
            --hover-color: #1a2c6b;
            --white-color: #ffffff;
            --success-color: #38a169;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Improved Typography */
        body {
            font-family: poppins;
            background-color: var(--background-color);
            line-height: 1.6;
            color: var(--text-color);
        }

        h2 {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
            letter-spacing: -0.5px;
        }

        /* Enhanced Container Styling */
        .payments-container {
            width: calc(100% - 300px);
            max-width: 1400px;
            margin: 2rem auto;
            background: var(--white-color);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 2.5rem;
            margin-left: 280px;
            overflow-x: auto;
        }

        /* Sophisticated Table Design */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--white-color);
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        th {
            background-color: var(--primary-color);
            color: var(--white-color);
            font-weight: 600;
            padding: 1.25rem;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
        }

        td {
            padding: 1.25rem;
            border-bottom: 1px solid var(--accent-color);
            font-size: 0.95rem;
            vertical-align: top;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #f6f7ff;
        }

        /* Enhanced Item Details Card */
        .item-details {
            background: var(--background-color);
            border-radius: 8px;
            padding: 1rem;
            margin: 0.5rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .item-details ul {
            margin: 0;
            padding: 0;
        }

        .item-details li {
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--accent-color);
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .item-details li:last-child {
            border-bottom: none;
        }

        .item-attribute {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.25rem 0;
        }

        .item-attribute strong {
            color: var(--primary-color);
            font-weight: 500;
            font-size: 0.875rem;
        }

        .item-attribute span {
            color: var(--text-color);
            font-weight: 400;
            text-align: right;
        }

        /* Status Badges */
        .payment-method {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: capitalize;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .payments-container {
                width: calc(100% - 60px);
                margin-left: 60px;
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .payments-container {
                width: 100%;
                margin-left: 0;
                border-radius: 0;
            }

            th, td {
                padding: 1rem;
                font-size: 0.85rem;
            }

            .item-details li {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
        }

        /* Empty State Styling */
        td[colspan="7"] {
            text-align: center;
            padding: 3rem;
            color: #718096;
            font-style: italic;
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