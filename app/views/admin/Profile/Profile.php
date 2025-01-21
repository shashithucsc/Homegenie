<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Profile - HomeGenie</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierProfile.css">
   
</head>
<body>
    <?php require APPROOT . '/views/admin/sidebar.php'; ?>
    <div class="hg-supplier-container">
        <header class="hg-supplier-header">
            <h1>Supplier Profile</h1>
        </header>
        <main class="hg-supplier-main">
            <section class="hg-supplier-info">
                <img src="<?php echo URLROOT; ?>/public/img/<?php echo $data['supplier']->profile_image; ?>" alt="Supplier Avatar" class="hg-supplier-avatar">
                <div class="hg-supplier-details">
                    <h2 class="hg-supplier-name"><?php echo $data['supplier']->first_name . ' ' . $data['supplier']->last_name; ?></h2>
                    <p class="hg-supplier-email"><?php echo $data['supplier']->email; ?></p>
                    <p class="hg-supplier-phone"><?php echo $data['supplier']->contact_number; ?></p>
                    <p class="hg-supplier-address"><?php echo $data['supplier']->address; ?></p>
                </div>
            </section>
            <section class="hg-supplier-stats">
                <h3>Statistics</h3>
                <div class="hg-stats-grid">
                    <div class="hg-stat-item">
                        <h4>Total Products</h4>
                        <p><?php echo count($data['products']); ?></p>
                    </div>
                    <div class="hg-stat-item">
                        <h4>Orders Fulfilled</h4>
                        <p>120</p> <!-- Replace with actual data -->
                    </div>
                    <div class="hg-stat-item">
                        <h4>Pending Orders</h4>
                        <p>30</p> <!-- Replace with actual data -->
                    </div>
                    <div class="hg-stat-item">
                        <h4>Rating</h4>
                        <p>4.8/5</p> <!-- Replace with actual data -->
                    </div>
                </div>
            </section>
            <section class="hg-supplier-actions">
                <h3>Actions</h3>
                <button class="hg-action-btn">Edit Profile</button>
                <button class="hg-action-btn">View Products</button>
                <button class="hg-action-btn">Logout</button>
            </section>
            <section class="hg-supplier-products">
                <h3>Supplier Products</h3>
                <div class="hg-products-grid">
                    <?php foreach ($data['products'] as $product): ?>
                        <div class="hg-product-item">
                            <h4><?php echo $product->product_name; ?></h4>
                            <p>Rs. <?php echo $product->price; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
