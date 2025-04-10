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
                    <img src="<?php echo URLROOT; ?>/public/img/search.png" alt="Search Icon"
                        class="top-bar-search-icon">
                </button>
            </form>
        </div>
    </div>

    <div class="main2">
        <div class="box-container">
            <div class="left-section">
                <img src="<?php echo URLROOT; ?>/public/img/home.png" alt="Descriptive Image">
            </div>
            <div class="right-section">
                <h2>HomeGenie Special Christmas Offers</h2>
                <p>Celebrate this Christmas with HomeGenie! Enjoy exclusive discounts on essential home services and
                    products.</p>


                <!-- <p>Hurry! Offer ends in: <span id="timer"></span></p>
                <script>
                    const end = new Date("Dec 25, 2025 23:59:59").getTime();
                    const timer = setInterval(function () {
                        const now = new Date().getTime();
                        const distance = end - now;

                        if (distance < 0) {
                            clearInterval(timer);
                            document.getElementById("timer").innerHTML = "EXPIRED";
                            return;
                        }

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
                        const minutes = Math.floor((distance / (1000 * 60)) % 60);
                        const seconds = Math.floor((distance / 1000) % 60);

                        document.getElementById("timer").innerHTML =
                            `${days}d ${hours}h ${minutes}m ${seconds}s`;
                    }, 1000);
                </script> -->

            </div>
        </div>

        <section class="categories">
            <h1>Explore Popular Categories</h1>
            <div class="category-buttons">
                <a href="<?php echo URLROOT; ?>/StorePageController/cleaning" class="button">Cleaning</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/electricity" class="button">Electrical</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/painting" class="button">Painting</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/carpentry" class="button">Carpentry</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/masonary" class="button">Masonry</a>
            </div>
        </section>

        <section class="seasonal">
            <h1>Special Offers</h1>
            <div class="seasonal-card">
                <?php if (isset($data['data1']) && is_array($data['data1'])): ?>
                    <?php foreach ($data['data1'] as $item): ?>
                        <div class="offer-item">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($item->image); ?>"
                                alt="<?php echo htmlspecialchars($item->description); ?>">
                            <h3><?php echo htmlspecialchars($item->description); ?></h3>
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
                                <form action="<?php echo URLROOT; ?>/StorePageController/addToWishlist" method="POST">
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

    <!-- save button popup messsage javascript -->
    <?php if (isset($_SESSION['wishlist_msg'])): ?>
        <script>
            alert("<?php echo $_SESSION['wishlist_msg']; ?>");
        </script>
        <?php unset($_SESSION['wishlist_msg']); ?>
    <?php endif; ?>


    <?php require_once APPROOT . '/views/footer.php'; ?>
</body>

</html>