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

                    <!-- More Details Toggle -->
                    <button class="more-btn" onclick="toggleDetails(<?php echo $item->item_id; ?>)">More Details</button>

                    <!-- Floating More Details Box -->
                    <div id="details_<?php echo $item->item_id; ?>" class="details-popup" style="display: none;">
                        <span class="close-btn" onclick="toggleDetails(<?php echo $item->item_id; ?>)">✖</span>

                        <!-- Description -->
                        <p><?php echo nl2br(htmlspecialchars($item->description)); ?></p>

                        <!-- Average Rating -->
                        <p>Rating:
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo ($i <= round($item->average_rating)) ? '★' : '☆';
                            }
                            ?> (<?php echo number_format($item->average_rating, 1); ?>/5)
                        </p>

                        <!-- Comments Section -->
                        <div class="comments">
                            <strong>Customer Reviews:</strong>
                            <?php if (!empty($item->comments)): ?>
                                <ul>
                                    <?php foreach ($item->comments as $comment): ?>
                                        <li>
                                            <strong><?php echo htmlspecialchars($comment->first_name); ?>:</strong>
                                            <span><?php echo htmlspecialchars($comment->comment); ?></span>
                                            (<?php echo $comment->rating; ?>★)
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>No reviews yet.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Rate & Comment Form -->
                        <form action="<?php echo URLROOT; ?>/StorePageController/addReview" method="POST"
                            class="review-form">
                            <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">

                            <label for="rating">Rate:</label>
                            <select name="rating" required>
                                <option value="">Choose</option>
                                <?php for ($r = 1; $r <= 5; $r++): ?>
                                    <option value="<?php echo $r; ?>"><?php echo $r; ?> ★</option>
                                <?php endfor; ?>
                            </select>

                            <label for="comment">Comment:</label>
                            <textarea name="comment" rows="2" placeholder="Write a review..." required></textarea>

                            <button type="submit">Submit Review</button>
                        </form>
                    </div>

                    <div class="quantity-container">
                        <label for="quantity_<?php echo $item->item_id; ?>">Quantity:</label>
                        <input type="number" id="quantity_<?php echo $item->item_id; ?>" name="quantity" value="1"
                            min="1" max="<?php echo $item->available_quantity; ?>"
                            onchange="checkQuantity(<?php echo $item->item_id; ?>)">
                    </div>
                    <div class="button-container">
                        <form action="<?php echo URLROOT; ?>/StorePageController/addToCart" method="POST">
                            <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
                            <input type="hidden" id="available_quantity_<?php echo $item->item_id; ?>"
                                value="<?php echo $item->available_quantity; ?>">
                            <button type="submit" class="add-button">Add</button>
                        </form>

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

<script>
function toggleDetails(id) {
    const popup = document.getElementById('details_' + id);
    popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
}
</script>

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