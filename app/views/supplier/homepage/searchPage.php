<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/storeHomepage.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">
</head>

<body>
    <?php require_once APPROOT . '/views/supplier/navbar/navbar.php'; ?>

    <div class="top-bar">
        <div class="top-bar-search">
            <form action="<?php echo URLROOT; ?>/StorePageController/search" method="POST">
                <input type="text" name="search_query" placeholder="Search here..." class="top-bar-search-input">
                <button type="submit" class="top-bar-search-button">
                    <img src="<?php echo URLROOT; ?>/public/img/search.png" alt="Search Icon" class="top-bar-search-icon">
                </button>
            </form>
        </div>
    </div>

    
        </div>

        <section class="categories">
            <h1>Your Search Result</h1>
            
        </section>

       

        <section class="box">
        
            <section class="fetch-items">
                <?php if (!empty($data['items'])): ?>
                    <?php foreach ($data['items'] as $item): ?>
                        <div class="item">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($item->image_path); ?>" 
                                 alt="<?php echo htmlspecialchars($item->item_name); ?>">
                            <h3><?php echo htmlspecialchars($item->item_name); ?></h3>
                            <p>Supplier: <?php echo htmlspecialchars($item->supplier_name); ?></p>
                            <p>Rs. <?php echo htmlspecialchars($item->selling_price); ?></p>
                            
                            <div class="quantity-container">
                                <label for="quantity_<?php echo $item->item_id; ?>">Quantity:</label>
                                <input type="number" id="quantity_<?php echo $item->item_id; ?>" name="quantity" value="1"
                                       min="1" max="<?php echo $item->available_quantity; ?>"
                                       onchange="checkQuantity(<?php echo $item->item_id; ?>)">
                            </div>
                            <div class="button-container">
                                <!-- Add to Cart -->
                                <form action="<?php echo URLROOT; ?>/StorePageController/addToCart" method="POST">
                                    <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
                                    <input type="hidden" id="available_quantity_<?php echo $item->item_id; ?>"
                                           value="<?php echo $item->available_quantity; ?>">

                                    <button type="submit" class="add-button">Add</button>
                                </form>

                                <!-- Save to Wishlist -->
                                <form action="<?php echo URLROOT; ?>/WishlistController/saveItem" method="POST">
                                    <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
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
    </div>

    <script>
        function checkQuantity(itemId) {
            const quantityInput = document.getElementById('quantity_' + itemId);
            const maxQuantity = document.getElementById('available_quantity_' + itemId).value;
            if (quantityInput.value > maxQuantity) {
                alert('Cannot select more than available inventory!');
                quantityInput.value = maxQuantity;
            }
        }
    </script>

    <?php require_once APPROOT . '/views/footer.php'; ?>
</body>
</html>
