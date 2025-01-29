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
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierDashboard.css">
   
    
</head>

<body>
   
    <div class="dashboard-container">
        <div class="header1">
           
            <div class="welcome-container">
                <h2>Welcome to Sales Dashboard</h2>
            </div>
            <div class="user-info">
                <!-- Display the logged-in user's name -->
                <span><?php echo htmlspecialchars($user_name); ?></span>

                <!-- Display the profile picture -->
                <img src="<?php echo URLROOT . '/public/img/' . htmlspecialchars($profile_pic); ?>" alt="User Avatar" onclick="toggleDropdown()">

                <div class="dropdown" id="dropdown">
                    <a href="myProfile.html">View Profile</a>
                    <a href="<?php echo URLROOT; ?>LoginController/logout">Log Out</a>
                </div>
            </div>
        </div>

        <div class="notifications">
            <h3>Notifications</h3>
            <ul class="notifications-list">
                <li>New customer message received</li>
                <li>New order placed by customer</li>
            </ul>
        </div>

        
        <div class="sales-summary">
    <div class="summary-box" title="Total revenue from sales">
        <h3>Total Sales</h3>
        <p class="amount">
            <?php echo isset($data['totalSales']) ? '$' . number_format($data['totalSales'], 2) : '$0.00'; ?>
        </p>
        <div class="progress-bar">
            <div class="progress" style="width: <?php echo isset($data['totalSales']) ? ($data['totalSales'] / 1000) * 100 : 0; ?>%"></div>
        </div>
    </div>
    
    <div class="summary-box" title="Total number of customers">
        <h3>Total Customers</h3>
        <p class="amount">
            <?php echo isset($data['totalCustomers']) ? number_format($data['totalCustomers']) : '0'; ?>
        </p>
    </div>
    
    <div class="summary-box" title="Total products available">
        <h3>Total Products</h3>
        <p class="amount">
            <?php echo isset($data['totalProducts']) ? number_format($data['totalProducts']) : '0'; ?>
        </p>
    </div>
    
    <div class="summary-box" title="Top selling category">
        <h3>Top Category</h3>
        <p class="amount">
            <?php echo isset($data['topCategory']) ? htmlspecialchars($data['topCategory'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>
        </p>
    </div>
    
    <div class="summary-box" title="Most popular product">
        <h3>Top Product</h3>
        <p class="amount">
            <?php echo isset($data['topProduct']) ? htmlspecialchars($data['topProduct'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>
        </p>
    </div>
</div>







        <div class="bar-chart">
            <h3>Sales Overview</h3>
            <div class="bar-container">
                <div class="bar" style="height: 50%;">Jan</div>
                <div class="bar" style="height: 70%;">Feb</div>
                <div class="bar" style="height: 60%;">Mar</div>
                <div class="bar" style="height: 80%;">Apr</div>
                <div class="bar" style="height: 90%;">May</div>
            </div>
        </div>

        <div class="buttons">
            <button class="btn">Quotations</button>
            <button class="btn">Sales Reports</button>
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