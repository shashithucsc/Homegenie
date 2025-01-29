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
                    <?php foreach ($data['inventoryReport'] as $report) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($report->category); ?></td>
                            <td><?php echo $report->total_items; ?></td>
                            <td><?php echo $report->sold_items; ?></td>
                            <td><?php echo $report->remaining_stock; ?></td>
                            <td>Rs. <?php echo number_format($report->total_value, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
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
                    <?php foreach ($data['reorderSuggestions'] as $reorder) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reorder->item_name); ?></td>
                            <td><?php echo $reorder->current_stock; ?></td>
                            <td><?php echo $reorder->reorder_quantity > 0 ? $reorder->reorder_quantity : 'N/A'; ?></td>
                            <td>Rs. <?php echo number_format($reorder->suggested_order_value, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>
