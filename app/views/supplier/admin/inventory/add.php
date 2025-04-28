<?php ?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inventory Item</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SupplierAddItems.css">
</head>

<body>
    <?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>
    <div class="container">
        <header>
            <h1>Add Inventory Item</h1>
        </header>
        <main>
            <form action="<?php echo URLROOT; ?>/InventoryController/add" method="POST" enctype="multipart/form-data"
                class="inventory-form">
                <div class="form-group">
                    <label for="item_name">Item Name:</label>
                    <input type="text" id="item_name" name="item_name" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" required>
                </div>
                <div class="form-group">
                    <label for="selling_price">Selling Price ($):</label>
                    <input type="number" id="selling_price" name="selling_price" step="0.01" min="0.01" required>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                        <option value="Cleaning">Cleaning</option>
                        <option value="Electricity">Electricity</option>
                        <option value="Plumbing">Plumbing</option>
                        <option value="Carpentry">Carpentry</option>
                        <option value="Painting">Painting</option>
                        <option value="Masonary">Masonary</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Added Date:</label>
                    <input type="date" id="date" name="date" required 
                           oninput="this.setCustomValidity(''); if (new Date(this.value) < new Date()) this.setCustomValidity('Past dates are not allowed.');">
                </div>
                <div class="form-group">
                    <label for="image">Item Image:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="submit-btn">Add Item</button>
                <br>
                <a href="<?php echo URLROOT; ?>/InventoryController" class="bck-btn">Back to Inventory</a>
            </form>
        </main>
    </div>
</body>

</html>