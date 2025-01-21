<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierCart.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
</head>

<body>
    <?php require_once APPROOT . '/views/navbar/navbar.php'; ?>

    <main>
        <div class="cart-container">
            <h1>Checkout</h1>

            <!-- Order Summary -->
            <div class="cart-summary">
                <h2>Order Summary</h2>
                <p>Total Items: <?php echo htmlspecialchars($data['total_items']); ?></p>
                <p>Subtotal: Rs. <?php echo htmlspecialchars($data['subtotal']); ?></p>
                <p>Delivery Fee: Rs. 100</p>
                <h3>Grand Total: Rs. <?php echo htmlspecialchars($data['subtotal'] + 100); ?></h3>
            </div>

            <!-- Address Input -->
            <div class="checkout-section">
                <h2>Delivery Address</h2>
                <form action="<?php echo URLROOT; ?>/CartController/confirmOrder" method="POST">
    <textarea name="delivery_address" rows="4" placeholder="Enter your delivery address here..." required></textarea>

    <label>
        <input type="radio" name="payment_method" value="cod" required> Cash on Delivery
    </label><br>
    <label>
        <input type="radio" name="payment_method" value="card"> Card Payment
    </label>
    <button type="submit" class="button">Confirm Order</button>
</form>


            <div class="checkout">
                <a href="<?php echo URLROOT; ?>/StorePageController/index" class="button">Back to Store</a>
            </div>
        </div>
    </main>

    <?php require_once APPROOT . '/views/footer.php'; ?>
</body>

</html>
