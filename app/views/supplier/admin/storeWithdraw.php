<?php
require_once APPROOT . '/views/supplier/admin/sidebar.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw Earnings</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/storeWithdraw.css">
</head>

<body>
<div class="dashboard-container">
    <div class="header1">
        <div class="welcome-container">
            <h2>Withdraw Earnings</h2>
        </div>
    </div>

    <div class="sales-summary">
        <div class="summary-box">
            <h3>Total Earnings</h3>
            <div class="amount">
            <?php echo isset($data['yourEarnings']) ? '$' . number_format($data['yourEarnings'], 2) : '$0.00'; ?>
            </div>
        </div>
    </div>

    <div class="notifications">
        <h3>Withdrawal Request</h3>
        <form action="process_withdrawal.php" method="POST">
            <div class="form-group">
                <label for="bankName">Bank Name</label>
                <input type="text" id="bankName" name="bankName" required>
            </div>

            <div class="form-group">
                <label for="accountNumber">Account Number</label>
                <input type="text" id="accountNumber" name="accountNumber" required>
            </div>

            <div class="form-group">
                <label for="amount">Withdraw Amount (Rs)</label>
                <input type="number" id="amount" name="amount" min="100" required>
            </div>

            <div class="buttons">
                <button type="submit" class="btn">Request Withdrawal</button>
            </div>
        </form>
    </div>
</div>
</body>

</html>
