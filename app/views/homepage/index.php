<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/storeHomepage.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">


</head>
<?php require_once APPROOT . '/views/navbar/navbar.php'; ?>

<body>



    <div class="top-bar">
        <div class="top-bar-search">
            <input type="text" placeholder="Search here..." class="top-bar-search-input">
            <img src="<?php echo URLROOT; ?>/public/img/search.png" alt="Search Icon" class="top-bar-search-icon">
        </div>


    </div>

    <div class="main2">

        <div class="box-container">
            <div class="left-section">
                <img src="<?php echo URLROOT; ?>/public/img/slide1.jpg" alt="Descriptive Image">
            </div>
            <div class="right-section">
                <h2>HomeGenie Special Christmas Offers </h2>
                <p>
                    Celebrate this Christmas with HomeGenie! Enjoy exclusive discounts on essential home services and
                    products. From festive decorations to must-have home supplies, find everything you need to make your
                    holiday season brighter. Don't miss out on these limited-time deals designed to bring joy and
                    savings to your Christmas celebrations!
                </p>
            </div>
        </div>
        <br>
        <br>
        <br>


        <section class="categories">
            <h1>Explore Popular Categories</h1>
            <div class="category-buttons">
                <a href="<?php echo URLROOT; ?>/StorePageController/cleaning" class="button">Cleaning</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/electricity" class="button">Electrical</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/painting" class="button">Painting</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/carpentry" class="button">Carpentry</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/masonary" class="button">Masonary</a>
            </div>
        </section>




        <section class="seasonal">
            <h1>Special Offers</h1>
            <div class="seasonal-card">
                <?php if (isset($data['data1']) && is_array($data['data1'])): ?>
                    <?php foreach ($data['data1'] as $item): ?>
                        <div class="offer-item">
                            <?php
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($item->image) . '" alt="' . htmlspecialchars($item->description) . '">';
                            echo '<h3>' . htmlspecialchars($item->description) . '</h3>';
                            ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No items available.</p>
                <?php endif; ?>
            </div>
        </section>


        <section class="box">
    <h1>Plumbing...</h1>
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

    <script src="script.js"></script>
    <?php require_once APPROOT . '/views/footer.php'; ?>
    </div>
</body>

</html>