<?php




$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

require_once APPROOT . '/views/supplier/admin/sidebar.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Sales Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierDashboard.css">


</head>

<body>

    <div class="supplier-dashboard-container">
        <div class="supplier-dashboard-header">
            <div class="supplier-welcome-container">
                <h2>Welcome to Sales Dashboard</h2>
            </div>
            <div class="supplier-user-info">
                <span><?php echo htmlspecialchars($user_name); ?></span>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['profile_pic']); ?>" alt="Profile Picture" class="profile-pic" onclick="toggleDropdown()">
                <div class="supplier-dropdown" id="dropdown">
                    <a href="myProfile.html">View Profile</a>
                    <a href="<?php echo URLROOT; ?>LoginController/logout">Log Out</a>
                </div>
            </div>
        </div>

        <div class="supplier-dashboard-section">
            <div class="supplier-section-header">
                <h2>Sales Overview</h2>
            </div>
            <div class="supplier-sales-summary">
                <div class="supplier-summary-box supplier-earnings-card supplier-card-large" onclick="window.location.href='<?php echo URLROOT; ?>/SupplierController/storeWithdraw'">
                    <h3>Your Earnings</h3>
                    <p class="supplier-amount">
                        <?php echo isset($data['yourEarnings']) ? '$' . number_format($data['yourEarnings'], 2) : '$0.00'; ?>
                    </p>
                    <div class="supplier-card-icon"><i class="fas fa-wallet"></i></div>
                </div>

                <div class="supplier-summary-box supplier-card-medium">
                    <h3>Total Sales</h3>
                    <p class="supplier-amount">
                        <?php echo isset($data['totalSales']) ? '$' . number_format($data['totalSales'], 2) : '$0.00'; ?>
                    </p>
                    <div class="supplier-card-icon"><i class="fas fa-chart-line"></i></div>
                </div>

                <div class="supplier-summary-box supplier-card-small">
                    <h3>Total Customers</h3>
                    <p class="supplier-amount">
                        <?php echo isset($data['totalCustomers']) ? number_format($data['totalCustomers']) : '0'; ?>
                    </p>
                    <div class="supplier-card-icon"><i class="fas fa-users"></i></div>
                </div>

                <div class="supplier-summary-box supplier-card-small">
                    <h3>Total Products</h3>
                    <p class="supplier-amount">
                        <?php echo isset($data['totalProducts']) ? number_format($data['totalProducts']) : '0'; ?>
                    </p>
                    <div class="supplier-card-icon"><i class="fas fa-boxes"></i></div>
                </div>

                <div class="supplier-summary-box supplier-card-medium">
                    <h3>Top Product</h3>
                    <p class="supplier-amount">
                        <?php echo isset($data['topProduct']) ? htmlspecialchars($data['topProduct'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>
                    </p>
                    <div class="supplier-card-icon"><i class="fas fa-crown"></i></div>
                </div>

                <div class="supplier-summary-box supplier-card-small">
                    <h3>Pending Orders</h3>
                    <p class="supplier-amount">
                        <?php echo $data['pendingOrdersCount']; ?>
                    </p>
                    <div class="supplier-card-icon"><i class="fas fa-clock"></i></div>
                </div>

                <div class="supplier-summary-box supplier-card-small">
                    <h3>Completed Orders</h3>
                    <p class="supplier-amount">
                        <?php echo $data['completedOrdersCount']; ?>
                    </p>
                    <div class="supplier-card-icon"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
        </div>

        <div class="supplier-buttons-section">
            <a class="supplier-dashboard-btn" href="<?php echo URLROOT; ?>/SupplierController/storeWithdraw">Withdraw Money</a>
            <a class="supplier-dashboard-btn" href="<?php echo URLROOT; ?>/SupplierController/SalesReport">Sales Reports</a>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
    </script>


</body>

</html>