<?php



require_once APPROOT . '/views/supplier/admin/sidebar.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Sales Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierDashboard.css">
   
    
</head>
<div class="dashboard-container">
    <div class="header1">
        <div class="welcome-container">
            <h2>Withdraw Earnings</h2>
        </div>
    </div>

    <!-- Total Earnings Summary -->
    <div class="sales-summary">
        <div class="summary-box">
            <h3>Total Earnings</h3>
            <div class="amount">
            <?php echo htmlspecialchars($data['getEarnings']); ?>
            </div>
        </div>
    </div>

    <!-- Withdraw Section -->
    <div class="notifications">
        <h3>Withdrawal Request</h3>
        <form action="process_withdrawal.php" method="POST">
            <div style="margin-bottom: 15px;">
                <label for="bankName">Bank Name</label><br>
                <input type="text" id="bankName" name="bankName" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="accountNumber">Account Number</label><br>
                <input type="text" id="accountNumber" name="accountNumber" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="amount">Withdraw Amount (Rs)</label><br>
                <input type="number" id="amount" name="amount" min="100" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
            </div>

            <div class="buttons">
                <button type="submit" class="btn">Request Withdrawal</button>
            </div>
        </form>
    </div>
</div>
