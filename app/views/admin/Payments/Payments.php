<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <style>
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        .payments-container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            margin-left: 250px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 2.5rem;
            position: relative;
            padding-bottom: 15px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(135deg, #08f, #04c);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            overflow: hidden;
            min-width: 700px;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        table th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table tr:hover {
            background-color: #f1f3f5;
            transition: background-color 0.3s ease;
        }

        .status {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8rem;
            border-radius: 4px;
            padding: 5px 10px;
            display: inline-block;
        }

        .status[data-status="Completed"] {
            background-color: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
            border: 1px solid #4CAF50;
            width: 120px;
        }

        .status[data-status="Pending"] {
            background-color: rgba(255, 152, 0, 0.1);
            color: #FF9800;
            border: 1px solid #FF9800;
            width: 120px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .payments-container {
                margin-left: 0;
                padding: 15px;
            }

            table {
                font-size: 0.9rem;
            }

            table th, table td {
                padding: 10px;
            }
        }

        /* Scrollbar for table */
        .payments-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>
<?php require APPROOT . '/views/admin/sidebar.php'; ?>
    <div class="payments-container">
        <h2>Customer Payments</h2>
        <table>
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Payment Date</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>CUS001</td>
                    <td>2024-09-10</td>
                    <td>LED 15W Bulb</td>
                    <td>$10</td>
                    <td>Credit Card</td>
                    <td class="status" data-status="Completed">Completed</td>
                </tr>
                <tr>
                    <td>CUS002</td>
                    <td>2024-09-12</td>
                    <td>Multi Meter</td>
                    <td>$45</td>
                    <td>PayPal</td>
                    <td class="status" data-status="Pending">Pending</td>
                </tr>
                <tr>
                    <td>CUS003</td>
                    <td>2024-09-14</td>
                    <td>3W Bulb</td>
                    <td>$5</td>
                    <td>PayPal</td>
                    <td class="status" data-status="Pending">Pending</td>
                </tr>
                <tr>
                    <td>CUS004</td>
                    <td>2024-09-16</td>
                    <td>Tester</td>
                    <td>$4</td>
                    <td>PayPal</td>
                    <td class="status" data-status="Completed">Completed</td>
                </tr>
                <tr>
                    <td>CUS001</td>
                    <td>2024-09-10</td>
                    <td>LED 15W Bulb</td>
                    <td>$10</td>
                    <td>Credit Card</td>
                    <td class="status" data-status="Completed">Completed</td>
                </tr>
                <tr>
                    <td>CUS002</td>
                    <td>2024-09-12</td>
                    <td>Multi Meter</td>
                    <td>$45</td>
                    <td>PayPal</td>
                    <td class="status" data-status="Pending">Pending</td>
                </tr>
                <tr>
                    <td>CUS001</td>
                    <td>2024-09-10</td>
                    <td>LED 15W Bulb</td>
                    <td>$10</td>
                    <td>Credit Card</td>
                    <td class="status" data-status="Completed">Completed</td>
                </tr>
                <tr>
                    <td>CUS002</td>
                    <td>2024-09-12</td>
                    <td>Multi Meter</td>
                    <td>$45</td>
                    <td>PayPal</td>
                    <td class="status" data-status="Pending">Pending</td>
                </tr>
                <tr>
                    <td>CUS003</td>
                    <td>2024-09-14</td>
                    <td>3W Bulb</td>
                    <td>$5</td>
                    <td>PayPal</td>
                    <td class="status" data-status="Pending">Pending</td>
                </tr>
                <tr>
                    <td>CUS004</td>
                    <td>2024-09-16</td>
                    <td>Tester</td>
                    <td>$4</td>
                    <td>PayPal</td>
                    <td class="status" data-status="Completed">Completed</td>
                </tr>
                <tr>
                    <td>CUS003</td>
                    <td>2024-09-14</td>
                    <td>3W Bulb</td>
                    <td>$5</td>
                    <td>PayPal</td>
                    <td class="status" data-status="Pending">Pending</td>
                </tr>
                <tr>
                    <td>CUS004</td>
                    <td>2024-09-16</td>
                    <td>Tester</td>
                    <td>$4</td>
                    <td>PayPal</td>
                    <td class="status" data-status="Completed">Completed</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
