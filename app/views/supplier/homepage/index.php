<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/storeHomepage.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM8d7xg1z5l5e5e5e5e5e5e5e5e5e5e5e5e5" crossorigin="anonymous">
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
                <img src="<?php echo URLROOT; ?>/public/img/neww.png" alt="Descriptive Image">
            </div>
            <div class="right-section">
                <h2>HomeGenie වෙසක් Discounts!!</h2>
                <p>HomeGenie වෙසක් උළෙල අරඹමින් විශේෂ වට්ටම් !! ඔබට අවශ්‍ය සියලු නිවසේ උපකරණ හා සේවා දැන් විශේෂ මිල අඩුවෙන් ලබාගන්න. </p>

            </div>
        </div>

        <section class="categories">
            <h1>Explore Popular Categories</h1>
            <div class="category-buttons">
                <a href="<?php echo URLROOT; ?>/StorePageController/cleaning" class="category-btn"><i
                        class="fa fa-broom"></i> Cleaning</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/electricity" class="category-btn"><i
                        class="fa fa-lightbulb"></i> Electrical</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/painting" class="category-btn"><i
                        class="fa fa-paint-brush"></i> Painting</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/carpentry" class="category-btn"><i
                        class="fa fa-hammer"></i> Carpentry</a>
                <a href="<?php echo URLROOT; ?>/StorePageController/masonary" class="category-btn"><i
                        class="fa fa-hammer"></i> Masonry</a>
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
                            <div class="wishlist-container">
                                <form action="<?php echo URLROOT; ?>/StorePageController/addToWishlist" method="POST"
                                    class="wishlist-form">
                                    <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
                                    <button type="submit" class="modern-btn-save">
                                        💙
                                    </button>
                                </form>
                            </div>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($item->image_path); ?>"
                                alt="<?php echo htmlspecialchars($item->item_name); ?>">
                            <h3><?php echo htmlspecialchars($item->item_name); ?></h3>


                            <p class="rating-stars">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= round($item->average_rating)) {
                                        echo '<span class="star filled">★</span>';
                                    } else {
                                        echo '<span class="star">☆</span>';
                                    }
                                }
                                ?>
                                (<?php echo number_format($item->average_rating, 1); ?>/5)
                            </p>


                            <p>Rs. <?php echo htmlspecialchars($item->selling_price); ?></p>

                            <button class="more-btn" onclick="openModal(<?php echo $item->item_id; ?>)">More Details</button>

                            
                            <div class="button-container">
                                <form action="<?php echo URLROOT; ?>/StorePageController/addToCart" method="POST"
                                    class="form-left same-row-form">
                                    <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
                                    <input type="hidden" id="available_quantity_<?php echo $item->item_id; ?>"
                                        value="<?php echo $item->available_quantity; ?>">

                                    <div class="quantity-container">
                                        <label for="quantity_<?php echo $item->item_id; ?>">Qty:</label>
                                        <input type="number" id="quantity_<?php echo $item->item_id; ?>" name="quantity"
                                            value="1" min="1" max="<?php echo $item->available_quantity; ?>"
                                            onchange="checkQuantity(<?php echo $item->item_id; ?>)">
                                    </div>

                                    <button type="submit" class="modern-btn-add">
                                        🛒&nbsp;Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No items available.</p>
                <?php endif; ?>
            </section>

            <?php foreach ($data['items'] as $item): ?>
                <div id="modal_<?php echo $item->item_id; ?>" class="modal">
                    <div class="modal-content">
                        <span class="close-btn" onclick="closeModal(<?php echo $item->item_id; ?>)">✖</span>
                        <h2><?php echo htmlspecialchars($item->item_name); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($item->description)); ?></p>


                        <p><strong>Supplier:</strong> <?php echo htmlspecialchars($item->supplier_name); ?></p>

                        <p class="rating-stars">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= round($item->average_rating)) {
                                    echo '<span class="star filled">★</span>';
                                } else {
                                    echo '<span class="star">☆</span>';
                                }
                            }
                            ?>
                            (<?php echo number_format($item->average_rating, 1); ?>/5)
                        </p>


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
                </div>
            <?php endforeach; ?>
        </section>
    </div>
    <?php require_once APPROOT . '/views/footer.php'; ?>

    <script>
        function openModal(id) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => modal.style.display = 'none');
            document.getElementById('modal_' + id).style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById('modal_' + id).style.display = 'none';
        }

        window.addEventListener('click', function (e) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });

        function checkQuantity(itemId) {
            const quantityInput = document.getElementById('quantity_' + itemId);
            const maxQuantity = parseInt(document.getElementById('available_quantity_' + itemId).value, 10);
            const selectedQuantity = parseInt(quantityInput.value, 10);

            if (selectedQuantity > maxQuantity) {
                alert('Cannot select more than available inventory!');
                quantityInput.value = maxQuantity;
            }
        }
    </script>
    <script>
        function toggleDropdown() {
            const menu = document.getElementById("dropdownMenu");
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }

        // Optional: close dropdown when clicking outside
        window.onclick = function (event) {
            const dropdown = document.getElementById("dropdownMenu");
            if (!event.target.closest('.user-dropdown')) {
                dropdown.style.display = "none";
            }
        };
    </script>

    <?php if (isset($_SESSION['wishlist_msg'])): ?>
        <script>
            alert("<?php echo $_SESSION['wishlist_msg']; ?>");
        </script>
        <?php unset($_SESSION['wishlist_msg']); ?>
    <?php endif; ?>

</body>

</html>