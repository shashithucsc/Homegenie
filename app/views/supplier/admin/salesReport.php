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
<?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>

<div class="reports-container">
    <header class="reports-header">
        <h2>Sales Reports</h2>
    </header>

    <main>
        
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
                    <?php foreach ($data['salesReport'] as $sale) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($sale->item_name); ?></td>
                            <td><?php echo $sale->sold_quantity; ?></td>
                            <td>Rs. <?php echo number_format($sale->revenue, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

       
    </main>
</div>
</body>
</html>
