<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierCart.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">
</head>

<body>
<?php require_once APPROOT . '/views/supplier/navbar/navbar.php'; ?>

    <main>
        <div class="cart-container">
            <h1>Your Cart</h1>
            <?php if (!empty($data['cartItems'])): ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['cartItems'] as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item->item_name); ?></td>
                                <td>Rs. <?php echo htmlspecialchars($item->selling_price); ?></td>
                                <td>
                                    <form action="<?php echo URLROOT; ?>/CartController/updateItemQuantity" method="POST">
                                        <input type="hidden" name="cart_item_id" value="<?php echo $item->id; ?>">
                                        <input type="number" name="new_quantity" value="<?php echo $item->quantity; ?>" min="1" max="<?php echo $item->available_quantity; ?>">
                                        <button type="submit" class="update">Update</button>
                                    </form>
                                </td>
                                <td>Rs. <?php echo htmlspecialchars($item->quantity * $item->selling_price); ?></td>
                                <td>
                                    <form action="<?php echo URLROOT; ?>/CartController/removeItem/<?php echo $item->id; ?>" method="POST">
                                        <button type="submit" class="remove">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h2>Total: Rs. <?php echo htmlspecialchars($data['total']); ?></h2>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>

            <div class="cart-summary">
                <h3>Cart Summary</h3>
                <p>Total: Rs. <?php echo isset($data['total']) ? htmlspecialchars($data['total']) : '0'; ?></p>
                <p>Delivery Fee: Rs. 100</p>
                <h4>Grand Total: Rs. <?php echo isset($data['total']) ? htmlspecialchars($data['total'] + 100) : '100'; ?></h4>
            </div>

            <div class="checkout">
                <a href="<?php echo URLROOT; ?>/CartController/checkout" class="button">Proceed to Checkout</a>
                <br><br>
                <a href="<?php echo URLROOT; ?>/StorePageController/index" class="button">Back to Store</a>
            </div>
        </div>
    </main>

    <?php require_once APPROOT . '/views/footer.php'; ?>
</body>

</html>
