<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Received Quotations</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierQuotation.css">
   
</head>
<body>
<?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>
    <div class="container">
        <h1>Received Quotations</h1>
        <div class="quotation-list">
            <div class="quotation-item">
                <h2>Quotation #1</h2>
                <p>Service Provider: Indipa perera</p>
                <p>Date: 2024-10-13</p>
                <p>Description: Electrical Tools</p>
                <p>Quotation Price: $150</p>
                <button class="action-btn">Accept</button>
                <button class="action-btn">Reject</button>
            </div>
            
            <div class="quotation-item">
                <h2>Quotation #2</h2>
                <p>Service Provider: Ruveen Samaranayake</p>
                <p>Date: 2024-10-16</p>
                <p>Description: Plumbing Tools</p>
                <p>Quotation Price: $1750</p>
                <button class="action-btn">Accept</button>
                <button class="action-btn">Reject</button>
            </div>

            <div class="quotation-item">
                <h2>Quotation #3</h2>
                <p>Service Provider: Gayashan Rathnayaka</p>
                <p>Date: 2024-10-19</p>
                <p>Description: Cleaning Tools</p>
                <p>Quotation Price: $1150</p>
                <button class="action-btn">Accept</button>
                <button class="action-btn">Reject</button>
            </div>

        </div>
    </div>
</body>
</html>
