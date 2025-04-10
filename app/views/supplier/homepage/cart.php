<!DOCTYPE html>
<html lang="en">
<?php require_once APPROOT . '/views/supplier/navbar/navbar.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierCart.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>


    <main>
        <div class="cart-container">
            <h1>Your Cart</h1>

            <?php if (!empty($data['cartItems'])): ?>
                <div class="cart-layout">
                    <div class="cart-items">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['cartItems'] as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="product-info">
                                                <strong><?php echo htmlspecialchars($item->item_name); ?></strong>
                                            </div>
                                        </td>
                                        <td>Rs. <?php echo htmlspecialchars($item->selling_price); ?></td>
                                        <td>
                                            <form action="<?php echo URLROOT; ?>/StorePageController/updateItemQuantity"
                                                method="POST" class="quantity-controls">
                                                <input type="hidden" name="cart_item_id" value="<?php echo $item->id; ?>">
                                                <input type="number" name="new_quantity" value="<?php echo $item->quantity; ?>"
                                                    min="1" max="<?php echo $item->available_quantity; ?>">
                                                <button type="submit" class="update-btn">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <strong>Rs.
                                                <?php echo htmlspecialchars($item->quantity * $item->selling_price); ?></strong>
                                        </td>
                                        <td>
                                            <form
                                                action="<?php echo URLROOT; ?>/StorePageController/removeItem/<?php echo $item->id; ?>"
                                                method="POST">
                                                <button type="submit" class="remove-btn">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="cart-sidebar">
                        <div class="cart-summary">
                            <h3>Cart Summary</h3>

                            <div class="summary-item">
                                <span>Subtotal</span>
                                <span id="subtotal">Rs.
                                    <?php echo isset($data['total']) ? htmlspecialchars($data['total']) : '0'; ?></span>
                            </div>

                            <!-- Province Selection -->
                            <div class="summary-item">
                                <label for="province">Select Province</label>
                                <select id="province" name="province" onchange="updateDeliveryFee()">
                                    <option value="" disabled selected>Select province</option>
                                    <option value="Western">Western</option>
                                    <option value="Central">Central</option>
                                    <option value="Southern">Southern</option>
                                    <option value="Northern">Northern</option>
                                    <option value="Eastern">Eastern</option>
                                    <option value="North Western">North Western</option>
                                    <option value="North Central">North Central</option>
                                    <option value="Uva">Uva</option>
                                    <option value="Sabaragamuwa">Sabaragamuwa</option>
                                </select>
                            </div>

                            <div class="summary-item">
                                <span>Delivery Fee</span>
                                <span id="delivery-fee">Rs. 0</span>
                            </div>

                            <div class="summary-total">
                                <span>Grand Total</span>
                                <span id="grand-total">
                                    Rs. <?php echo isset($data['total']) ? htmlspecialchars($data['total']) : '0'; ?>
                                </span>
                            </div>
                        </div>
                        <a href="<?php echo URLROOT; ?>/StorePageController/checkout" class="checkout-btn">
                            <i class="fas fa-credit-card mr-2"></i> Proceed to Checkout
                        </a>
                        <a href="<?php echo URLROOT; ?>/StorePageController/index" class="continue-shopping">
                            <i class="fas fa-arrow-left mr-2"></i> Continue Shopping
                        </a>

                    </div>



                </div>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <p>Your cart is empty.</p>
                <a href="<?php echo URLROOT; ?>/StorePageController/index" class="continue-shopping">
                    <i class="fas fa-arrow-left mr-2"></i> Browse Products
                </a>
            </div>
        <?php endif; ?>
        </div>
    </main>


    <script>
        const deliveryRates = {
            "Western": 200,
            "Central": 250,
            "Southern": 2500,
            "Northern": 350,
            "Eastern": 300,
            "North Western": 340,
            "North Central": 28,
            "Uva": 250,
            "Sabaragamuwa": 240
        };

        function updateDeliveryFee() {
            const province = document.getElementById('province').value;
            const deliveryFee = deliveryRates[province] || 0;

            const subtotalText = document.getElementById('subtotal').innerText.replace('Rs. ', '');
            const subtotal = parseFloat(subtotalText) || 0;

            const grandTotal = subtotal + deliveryFee;

            document.getElementById('delivery-fee').innerText = `Rs. ${deliveryFee}`;
            document.getElementById('grand-total').innerText = `Rs. ${grandTotal}`;
        }
    </script>


    <?php require_once APPROOT . '/views/footer.php'; ?>
</body>

</html>