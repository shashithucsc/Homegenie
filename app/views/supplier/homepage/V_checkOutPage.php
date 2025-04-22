<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierCart.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .payment-options {
            display: flex;
            gap: 20px;
            margin: 15px 0;
        }

        .payment-options label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkout .button {
            padding: 10px 20px;
            background-color: #004085;
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }

        .checkout .button:hover {
            background-color: #002f5f;
        }

        textarea {
            width: 100%;
            padding: 10px;
            resize: vertical;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
    </style>
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
                
                <!-- Hidden Grand Total -->
                <input type="hidden" name="grand_total" value="<?php echo $data['grand_total']; ?>">

                <!-- Payment Options -->
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

                <button type="submit" class="button">Confirm Order</button>
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
    document.getElementById('checkoutForm').addEventListener('submit', function (e) {
        const selected = document.querySelector('input[name="payment_method"]:checked');
        if (selected && selected.value === "card") {
            e.preventDefault();
            window.location.href = "<?php echo URLROOT; ?>/StorePageController/cardPayment";
        }
    });
</script>

<?php require_once APPROOT . '/views/footer.php'; ?>
</body>
</html>
