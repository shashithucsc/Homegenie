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
</body>

</html>