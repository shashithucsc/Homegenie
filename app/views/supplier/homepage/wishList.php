<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Items - HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/wishList.css">
</head>

<body>
    <?php require_once APPROOT . '/views/supplier/navbar/navbar.php'; ?>

    <div class="container2">
    <h1>Saved items</h1>

        <section class="saved-items">
            <?php if (!empty($data['items'])): ?>
                <?php foreach ($data['items'] as $item): ?>
                    <div class="item">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($item->image_path); ?>"
                            alt="<?php echo htmlspecialchars($item->item_name); ?>">

                        <h3><?php echo htmlspecialchars($item->item_name); ?></h3>
                        <p>Supplier: <?php echo htmlspecialchars($item->supplier_name); ?></p>
                        <p>Rs. <?php echo htmlspecialchars($item->selling_price); ?></p>



                        <div class="button-container">
                            <form action="<?php echo URLROOT; ?>/StorePageController/removeFromWishlist" method="POST">
                                <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>">
                                <button type="submit" class="remove-button">Remove</button>
                            </form>


                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No items available.</p>
            <?php endif; ?>
        </section>
    </div>

    <?php require_once APPROOT . '/views/footer.php'; ?>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const items = document.querySelectorAll('.item');
            items.forEach((item, index) => {
                item.style.opacity = 0;
                item.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.5s ease';
                    item.style.opacity = 1;
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>

</body>

</html>