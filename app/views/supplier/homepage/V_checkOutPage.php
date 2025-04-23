<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierCheckoutPage.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
</head>

<body>
<?php require_once APPROOT . '/views/supplier/navbar/navbar.php'; ?>

<main>
    <div class="cart-container">
        <h1>Checkout</h1>

        <!-- Order Summary -->
        <div class="cart-summary">
            <h2>Order Summary</h2>
            <p>Total Items: <?php echo htmlspecialchars($data['total_items']); ?></p>
            <h3>Grand Total: Rs. <?php echo htmlspecialchars($data['grand_total']); ?></h3>
            <p style="color: gray;">*Delivery charges were already added in your cart.</p>
        </div>

        <!-- Address Input -->
        <div class="checkout-section">
            <h2>Delivery Address</h2>
            <form id="checkoutForm" action="<?php echo URLROOT; ?>/StorePageController/confirmOrder" method="POST">
    <textarea name="delivery_address" rows="4" placeholder="Enter your delivery address here..." required></textarea>

    <input type="hidden" name="grand_total" value="<?php echo $data['grand_total']; ?>">

    <div class="payment-options">
        <label>
            <input type="radio" name="payment_method" value="cod" required>
            <i class="fas fa-money-bill-wave"></i> Cash on Delivery
        </label>
        <label>
            <input type="radio" name="payment_method" value="card">
            <i class="fas fa-credit-card"></i> Card Payment
        </label>
    </div>

    <button type="submit" class="confirm-button">Confirm Order</button>
</form>

            <div class="checkout" style="margin-top: 20px;">
                <a href="<?php echo URLROOT; ?>/StorePageController/index" class="button">
                    <i class="fas fa-arrow-left"></i> Back to Store
                </a>
            </div>
        </div>
    </div>
</main>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;

    if (selectedMethod === 'card') {
        e.preventDefault(); // Stop normal form submission

        // Redirect to card payment page, passing data via URL or session
        const grandTotal = document.querySelector('input[name="grand_total"]').value;
        const deliveryAddress = document.querySelector('textarea[name="delivery_address"]').value;

        // Optionally store data in session or URL params
        const encodedAddress = encodeURIComponent(deliveryAddress);
        window.location.href = `<?php echo URLROOT; ?>/StorePageController/cardPaymentPage?total=${grandTotal}&address=${encodedAddress}`;
    }

    // If COD is selected, let form submit normally
});
</script>

<?php require_once APPROOT . '/views/footer.php'; ?>
</body>
</html>
