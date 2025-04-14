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
   
    <section class="box">
    <h1>Cleaning...</h1>

        <section class="fetch-items">
            <?php if (!empty($data['items'])): ?>
                <?php foreach ($data['items'] as $item): ?>
                    <div class="item">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($item->image_path); ?>"
                            alt="<?php echo htmlspecialchars($item->item_name); ?>">
                        <h3><?php echo htmlspecialchars($item->item_name); ?></h3>
                        <p>Supplier: <?php echo htmlspecialchars($item->supplier_name); ?></p>
                        <p>Rs. <?php echo htmlspecialchars($item->selling_price); ?></p>

                        <button class="more-btn" onclick="openModal(<?php echo $item->item_id; ?>)">More Details</button>



                        <div class="button-container">
                            <div class="quantity-wrapper">
                                <form action="<?php echo URLROOT; ?>/StorePageController/addToCart" method="POST"
                                    class="form-left">
                                    <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
                                    <input type="hidden" id="available_quantity_<?php echo $item->item_id; ?>"
                                        value="<?php echo $item->available_quantity; ?>">

                                    <div class="quantity-container">
                                        <label for="quantity_<?php echo $item->item_id; ?>">Quantity:</label>
                                        <input type="number" id="quantity_<?php echo $item->item_id; ?>" name="quantity"
                                            value="1" min="1" max="<?php echo $item->available_quantity; ?>"
                                            onchange="checkQuantity(<?php echo $item->item_id; ?>)">
                                    </div>

                                    <button type="submit" class="add-button">Add</button>
                                </form>
                            </div>

                            <div class="button-row">
                                <!-- Save button form only -->
                                <form action="<?php echo URLROOT; ?>/StorePageController/addToWishlist" method="POST"
                                    class="form-right">
                                    <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
                                    <button type="submit" class="save-button">Save</button>
                                </form>
                            </div>
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

                    <p>Rating:
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo ($i <= round($item->average_rating)) ? '★' : '☆';
                        }
                        ?> (<?php echo number_format($item->average_rating, 1); ?>/5)
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

                    <form action="<?php echo URLROOT; ?>/StorePageController/addReview" method="POST" class="review-form">
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
    </script>



    <script>
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