<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Seasonal Offers</title>
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/manage_offers.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Manage Seasonal Offers</h1>
            <br>
            <hr>
            <a href="<?= URLROOT; ?>/StorePageController/index">
                <button class="store-btn">Back to Store</button>
            </a>
            <a href="<?= URLROOT; ?>/SupplierController/inventory">
                <button class="inventory-btn">Back to Inventory</button>
            </a>

        </header>
        <main>
            <section>
                <h2>Add Seasonal Offer</h2>
                <form action="<?= URLROOT; ?>/SupplierController/addOffer" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="description">Offer Description:</label>
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Offer Image:</label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                    </div>
                    <button type="submit">Add Offer</button>
                </form>
            </section>

            <section>
                <h2>Current Seasonal Offers</h2>
                <div class="offers-list">
                    <?php if (!empty($data['offers'])): ?>
                        <?php foreach ($data['offers'] as $offer): ?>
                            <div class="offer-item">
                                <img src="data:image/jpeg;base64,<?= base64_encode($offer->image); ?>" alt="Offer Image">
                                <p><?= htmlspecialchars($offer->description); ?></p>

                                <form action="<?= URLROOT; ?>/SupplierController/updateOffer" method="POST"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="offer_id" value="<?= $offer->id; ?>">
                                    <textarea name="description"
                                        rows="2"><?= htmlspecialchars($offer->description); ?></textarea>
                                    <input type="file" name="image" accept="image/*">
                                    <button type="submit" class="update-btn">Update</button>
                                </form>

                                <form action="<?= URLROOT; ?>/SupplierController/deleteOffer" method="POST">
                                    <input type="hidden" name="offer_id" value="<?= $offer->id; ?>">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No offers available.</p>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>
</body>

</html>