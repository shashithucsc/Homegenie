<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpentry Tools</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">  
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/storeHomepage.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">
</head>
<?php require_once APPROOT . '/views/supplier/navbar/navbar.php'; ?>
<body>
    
    <br>
    <br>
    <br>
    <br>
    
        <section class="box">
            <h1>Masonary...</h1>
            <section class="fetch-items">
        <?php if (isset($data['items']) && is_array($data['items'])): ?>
            <?php foreach ($data['items'] as $item): ?>
                <div class="item">
                    <?php
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($item->image_path) . '" alt="' . htmlspecialchars($item->item_name) . '">';
                    echo '<h3>' . htmlspecialchars($item->item_name) . '</h3>';
                    echo '<p>Supplier: ' . htmlspecialchars($item->supplier_name) . '</p>'; // Display supplier name
                    echo 'Rs. ' . htmlspecialchars($item->selling_price) . '';
                    ?>
                    <div class="button-container">
                        <!-- Add to Cart Button -->
                        <form action="<?php echo URLROOT; ?>/CartController/addToCart" method="POST">
                            <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
                            <input type="hidden" id="available_quantity_<?php echo $item->item_id; ?>"
                                value="<?php echo $item->available_quantity; ?>">

                            <!-- Quantity Spinner -->
                             <div class="quantity-container">
                                <label for="quantity_<?php echo $item->item_id; ?>">Quantity:</label>
                                <input type="number" id="quantity_<?php echo $item->item_id; ?>" name="quantity" value="1"
                                    min="1" max="<?php echo $item->available_quantity; ?>"
                                    onchange="checkQuantity(<?php echo $item->item_id; ?>)">
                            </div>
                            <button type="submit" class="add-button">Add</button>
                        </form>

                        <!-- Save to Wishlist Button -->
                        <form action="<?php echo URLROOT; ?>/WishlistController/saveItem" method="POST">
                            <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
                            <button type="submit" class="save-button">Save</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No items available.</p>
        <?php endif; ?>
    </section>
        </section>

        </main>
    </div>
    <?php require_once APPROOT . '/views/footer.php'; ?>
</body>
</html>
