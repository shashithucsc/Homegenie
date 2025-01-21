<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/reports.css">

</head>
<body>
<?php require APPROOT . '/views/admin/sidebar.php'; ?>

<div class="reports-container">
    <header class="reports-header">
        <h2>Inventory Reports</h2>
    </header>

    <main>
        <!-- Overall Inventory Statistics Section -->
        <section class="reports-section">
            <h3 class="reports-section-title">Overall Inventory Statistics</h3>
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Total Items</th>
                        <th>Sold Items</th>
                        <th>Remaining Stock</th>
                        <th>Total Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Cleaning</td>
                        <td>150</td>
                        <td>75</td>
                        <td>75</td>
                        <td>Rs. 150,000</td>
                    </tr>
                    <tr>
                        <td>Electricity</td>
                        <td>200</td>
                        <td>100</td>
                        <td>100</td>
                        <td>Rs. 250,000</td>
                    </tr>
                    <tr>
                        <td>Painting</td>
                        <td>80</td>
                        <td>40</td>
                        <td>40</td>
                        <td>Rs. 90,000</td>
                    </tr>
                    <tr>
                        <td>Masonary</td>
                        <td>120</td>
                        <td>50</td>
                        <td>70</td>
                        <td>Rs. 110,000</td>
                    </tr>
                    <tr>
                        <td>Carpentry</td>
                        <td>100</td>
                        <td>60</td>
                        <td>40</td>
                        <td>Rs. 85,000</td>
                    </tr>
                    <tr>
                        <td>Plumbing</td>
                        <td>130</td>
                        <td>70</td>
                        <td>60</td>
                        <td>Rs. 120,000</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Sales Report Section -->
        <section class="sales-report">
            <h3 class="reports-section-title">Sales Report</h3>
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Sold Quantity</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Item 1</td>
                        <td>50</td>
                        <td>Rs. 50,000</td>
                    </tr>
                    <tr>
                        <td>Item 2</td>
                        <td>30</td>
                        <td>Rs. 40,000</td>
                    </tr>
                    <tr>
                        <td>Item 3</td>
                        <td>20</td>
                        <td>Rs. 30,000</td>
                    </tr>
                    <tr>
                        <td>Item 4</td>
                        <td>15</td>
                        <td>Rs. 22,500</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Inventory Reorder Section -->
        <section class="inventory-reorder">
            <h3 class="reports-section-title">Inventory Reorder Suggestions</h3>
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Current Stock</th>
                        <th>Reorder Quantity</th>
                        <th>Suggested Order Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Item A</td>
                        <td>10</td>
                        <td>20</td>
                        <td>Rs. 15,000</td>
                    </tr>
                    <tr>
                        <td>Item B</td>
                        <td>5</td>
                        <td>30</td>
                        <td>Rs. 25,000</td>
                    </tr>
                    <tr>
                        <td>Item C</td>
                        <td>3</td>
                        <td>50</td>
                        <td>Rs. 45,000</td>
                    </tr>
                    <tr>
                        <td>Item D</td>
                        <td>8</td>
                        <td>20</td>
                        <td>Rs. 18,000</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</div>

</body>
</html>
