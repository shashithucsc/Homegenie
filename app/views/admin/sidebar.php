<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierSidebar.css">
   
</head>

<body>
    <div class="test">
        <nav class="sidebar">
            <header>
                <div class="image-text">
                    <span class="image">
                        <img src="<?php echo URLROOT; ?>/public/img/logo.png" alt="logo">
                    </span>
                    <div class="text header-text">
                        <span class="name">HOMEGENIE</span>
                    </div>
                </div>
            </header>

            <div class="menu-bar">
                <div class="menu">
                    <ul class="menu-links">

                        <li class="nav-link active">
                        <a href="<?php echo URLROOT; ?>/SupplierController/Dashboard" class="nav-link">
                                <i class='bx bxs-home-alt-2'></i>
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="<?php echo URLROOT; ?>/InventoryController/index" class="nav-link">
                                <i class='bx bx-basket'></i>
                                <span class="text nav-text">Inventory</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="<?php echo URLROOT; ?>/SupplierController/payments" class="nav-link">
                                <i class='bx bx-money-withdraw'></i>
                                <span class="text nav-text">Pending Orders</span>
                            </a>
                        </li>
                        
                        <li class="nav-link">
                            <a href="<?php echo URLROOT; ?>/SupplierController/quotations" class="nav-link">
                                <i class='bx bx-message-rounded-dots'></i>
                                <span class="text nav-text">Quotations</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="<?php echo URLROOT; ?>/SupplierController/ratings" class="nav-link">
                                <i class='bx bx-star'></i>
                                <span class="text nav-text">Ratings</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="<?php echo URLROOT; ?>/SupplierController/supplierProfile" class="nav-link">
                                <i class='bx bxs-id-card'></i>
                                <span class="text nav-text">Profile</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="bottom-content">
                    <div class="log-out">
                       <a href="<?php echo URLROOT; ?>/LoginController/logout" class="nav-link">
                            <i class='bx bx-log-out icon'></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</body>

</html>