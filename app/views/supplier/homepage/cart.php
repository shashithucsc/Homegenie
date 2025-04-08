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
                                            <form action="<?php echo URLROOT; ?>/StorePageController/updateItemQuantity" method="POST" class="quantity-controls">
                                                <input type="hidden" name="cart_item_id" value="<?php echo $item->id; ?>">
                                                <input type="number" name="new_quantity" value="<?php echo $item->quantity; ?>" min="1" max="<?php echo $item->available_quantity; ?>">
                                                <button type="submit" class="update-btn">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <strong>Rs. <?php echo htmlspecialchars($item->quantity * $item->selling_price); ?></strong>
                                        </td>
                                        <td>
                                            <form action="<?php echo URLROOT; ?>/StorePageController/removeItem/<?php echo $item->id; ?>" method="POST">
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
                                <span>Rs. <?php echo isset($data['total']) ? htmlspecialchars($data['total']) : '0'; ?></span>
                            </div>
                            <div class="summary-item">
                                <span>Delivery Fee</span>
                                <span>Rs. 100</span>
                            </div>
                            <div class="summary-total">
                                <span>Grand Total</span>
                                <span>Rs. <?php echo isset($data['total']) ? htmlspecialchars($data['total'] + 100) : '100'; ?></span>
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
    
    <?php require_once APPROOT . '/views/footer.php'; ?>
</body>
</html>