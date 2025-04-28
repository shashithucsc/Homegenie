<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/reports.css">
    <title>Sales Report</title>
</head>

<body>
<?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>

<div class="reports-container">
    <header class="reports-header">
        <h2><i class="fas fa-chart-line"></i> Sales Reports</h2>
        <p class="reports-subtitle">Overview of your sales performance</p>
    </header>

    <main>
        <section class="sales-report">
            <div class="reports-section-header">
                <h3 class="reports-section-title"><i class="fas fa-file-invoice-dollar"></i> Sales Report</h3>
                
            </div>
            
            <div class="reports-table-container">
                <table class="reports-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-box"></i> Item Name</th>
                            <th><i class="fas fa-shopping-cart"></i> Sold Quantity</th>
                            <th><i class="fas fa-money-bill-wave"></i> Revenue</th>
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
            </div>
        </section>
    </main>
</div>
</body>
</html>
