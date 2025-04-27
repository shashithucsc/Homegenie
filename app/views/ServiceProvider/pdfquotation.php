<!DOCTYPE html>
<html>
<head>
    <title>Quotation #<?php echo $quotation->quotation_id; ?></title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2563eb;
        }
        .company-name {
            font-size: 20px;
            color: #2563eb;
            margin: 0;
        }
        .quotation-title {
            color: #374151;
            margin: 10px 0;
            font-size: 16px;
        }
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .details-section {
            background: #f8fafc;
            padding: 10px;
            border-radius: 4px;
        }
        .details-section h2 {
            margin: 0 0 8px 0;
            font-size: 14px;
            color: #2563eb;
        }
        .detail-item {
            margin-bottom: 5px;
            display: flex;
        }
        .detail-label {
            font-weight: bold;
            color: #666;
            width: 80px;
        }
        .quotation-details {
            background-color: white;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .quotation-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 12px;
        }
        .quotation-table th {
            background-color: #2563eb;
            color: white;
            padding: 8px;
            text-align: left;
        }
        .quotation-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .quotation-table tr:last-child td {
            border-bottom: none;
        }
        .price-cell {
            font-weight: bold;
            color: #2563eb;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
            font-size: 10px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">HomeGenie</div>
        <p style="color: #666; margin: 5px 0;">Your Trusted Service Provider</p>
    </div>

    <h1 class="quotation-title">Quotation #<?php echo $quotation->quotation_id; ?></h1>
    <p style="text-align: center; color: #666; margin: 0 0 15px 0;">Generated on: <?php echo date('F d, Y', strtotime($quotation->created_at)); ?></p>

    <div class="details-grid">
        <div class="details-section">
            <h2>Service Provider</h2>
            <div class="detail-item">
                <div class="detail-label">Name:</div>
                <div><?php echo htmlspecialchars($service_provider->first_name . ' ' . $service_provider->last_name); ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Email:</div>
                <div><?php echo htmlspecialchars($service_provider->email); ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Phone:</div>
                <div><?php echo htmlspecialchars($service_provider->contact_number); ?></div>
            </div>
        </div>

        <div class="details-section">
            <h2>Customer</h2>
            <div class="detail-item">
                <div class="detail-label">Name:</div>
                <div><?php echo htmlspecialchars($customer->first_name . ' ' . $customer->last_name); ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Email:</div>
                <div><?php echo htmlspecialchars($customer->email); ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Phone:</div>
                <div><?php echo htmlspecialchars($customer->contact_number); ?></div>
            </div>
        </div>
    </div>

    <div class="quotation-details">
        <h2 style="color: #2563eb; margin: 0 0 10px 0; font-size: 14px;">Quotation Details</h2>
        <table class="quotation-table">
            <tr>
                <th>Appointment Description</th>
                <td><?php echo htmlspecialchars($appointment->description); ?></td>
            </tr>
            <tr>
                <th>Location</th>
                <td><?php echo htmlspecialchars($appointment->location); ?></td>
            </tr>
            <tr>
                <th>Quotation Details</th>
                <td><?php echo htmlspecialchars($quotation->quotation_details); ?></td>
            </tr>
            <tr>
                <th>Work Hours</th>
                <td><?php echo htmlspecialchars($quotation->work_hours); ?> hours</td>
            </tr>
            <tr>
                <th>Cost</th>
                <td class="price-cell">Rs: <?php echo number_format($quotation->cost, 2); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span style="color: <?php echo ($quotation->status === 'Approved' ? '#28a745' : ($quotation->status === 'Rejected' ? '#dc3545' : '#ffc107')); ?>;">
                        <?php echo htmlspecialchars($quotation->status); ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>This is a computer-generated quotation from HomeGenie</p>
        <p>Generated on: <?php echo date('F d, Y H:i:s'); ?></p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 15px;">
        <button onclick="window.print()" style="padding: 8px 16px; background-color: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
            Print
        </button>
    </div>
</body>
</html> 