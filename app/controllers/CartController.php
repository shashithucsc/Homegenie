<?php

require_once APPROOT . '/models/CartModel.php'; // Load CartModel

class CartController {
    private $cartModel;

    public function __construct() {
        $this->cartModel = new CartModel();
        session_regenerate_id(true);
    }

    public function addToCart() {
        if (!isset($_SESSION['user_id'])) {
            die('Error: User not logged in.');
        }
    
        $userId = $_SESSION['user_id'];
        $itemId = $_POST['item_id'];
        $quantity = (int)$_POST['quantity'];
        
        // Get supplier_id based on the item_id (assuming each item has a supplier associated with it)
        $supplierId = $this->cartModel->getSupplierIdByItemId($itemId);
        
        if (!$supplierId) {
            die('Error: Supplier ID not found.');
        }
        
        // Check available inventory
        $availableQuantity = $this->cartModel->getAvailableQuantity($itemId);
        if ($quantity > $availableQuantity) {
            $this->showPopup("Not enough stock available.", URLROOT . "/StorePagesController");
            return;
        }
    
        // Add item to cart and update inventory
        if ($this->cartModel->addItemToCart($userId, $itemId, $quantity, $supplierId)) {
            $this->cartModel->updateInventoryLevel($itemId, $availableQuantity - $quantity);
            $this->showPopup("Item(s) added to cart successfully!", URLROOT . "/StorePagesController");
        } else {
            $this->showPopup("Failed to add items to cart.", URLROOT . "/StorePagesController");
        }
    }
    
    public function removeItem($cartItemId) {
        if (!isset($_SESSION['user_id'])) {
            die('Error: User not logged in.');
        }
        
        // Get item details before removing
        $cartItem = $this->cartModel->getCartItemById($cartItemId);
        if ($cartItem) {
            $itemId = $cartItem->item_id;
            $quantity = $cartItem->quantity;

            // Remove item from cart and update inventory
            if ($this->cartModel->removeItemFromCart($cartItemId)) {
                $availableQuantity = $this->cartModel->getAvailableQuantity($itemId);
                $newQuantity = $availableQuantity + $quantity; // Restore the removed quantity
                $this->cartModel->updateInventoryLevel($itemId, $newQuantity);
                $this->showPopup("Item removed from cart successfully!", URLROOT . "/CartController/viewCart");
            } else {
                $this->showPopup("Failed to remove item.", URLROOT . "/CartController/viewCart");
            }
        }
    }

    public function updateItemQuantity() {
        if (!isset($_SESSION['user_id'])) {
            die('Error: User not logged in.');
        }

        $cartItemId = $_POST['cart_item_id'];
        $newQuantity = (int)$_POST['new_quantity'];

        // Get item details
        $cartItem = $this->cartModel->getCartItemById($cartItemId);
        $itemId = $cartItem->item_id;
        $availableQuantity = $this->cartModel->getAvailableQuantity($itemId);

        if ($newQuantity <= $availableQuantity) {
            // Update cart and inventory
            $this->cartModel->updateCartQuantity($cartItemId, $newQuantity);
            $this->cartModel->updateInventoryLevel($itemId, $availableQuantity - $newQuantity);
            $this->showPopup("Item quantity updated successfully!", URLROOT . "/CartController/viewCart");
        } else {
            $this->showPopup("Not enough stock available.", URLROOT . "/CartController/viewCart");
        }
    }

    private function showPopup($message, $redirectUrl) {
        // Pass message and redirect URL to the view
        $data = ['message' => $message, 'redirectUrl' => $redirectUrl];
        $this->view('homepage/cartElements/popup', $data);
    }

    private function view($view, $data = []) {
        extract($data);
        require_once APPROOT . '/views/' . $view . '.php';
    }

    public function viewCart() {
        $userId = $_SESSION['user_id'];
    
        $cartItems = $this->cartModel->getCartItemsByUserId($userId);
        $total = 0;
    
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->selling_price;
        }
        
        $this->view('homepage/cart', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }


    public function checkout() {
        $userId = $_SESSION['user_id']; // Assuming user_id is set in session
        $cartItems = $this->cartModel->getCartItemsByUserId($userId);
        
        $totalItems = 0;
        $subtotal = 0;
    
        foreach ($cartItems as $item) {
            $totalItems += $item->quantity;
            $subtotal += $item->quantity * $item->selling_price;
        }
    
        $this->view('homepage/V_checkOutpage', [
            'total_items' => $totalItems,
            'subtotal' => $subtotal
        ]);
    }


    public function confirmOrder() {
        if (!isset($_SESSION['user_id'])) {
            die('Error: User not logged in.');
        }
    
        $userId = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getCartItemsByUserId($userId);
        $totalAmount = 0;
    
        foreach ($cartItems as $item) {
            $totalAmount += $item->quantity * $item->selling_price;
        }
    
        // Get payment and delivery details
        $paymentMethod = $_POST['payment_method'] ?? null;
        $deliveryAddress = $_POST['delivery_address'] ?? null;
    
        if (!$paymentMethod || !$deliveryAddress) {
            $this->showPopup("Missing payment method or delivery address.", URLROOT . "/CartController/viewCart");
            return;
        }
    
        // Create the order in the sales table
        $saleId = $this->cartModel->createOrder($userId, $totalAmount, $paymentMethod, $deliveryAddress, $supplierId);
    
        if ($saleId) {
            // Add each item to the sales_items table using sale_id
            foreach ($cartItems as $item) {
                $this->cartModel->addOrderItem($saleId, $item->item_id, $item->quantity, $item->selling_price,$item->supplier_id);
            }
    
            // Clear the cart after the order is placed
            $this->cartModel->clearCart($userId);
    
            // Show success popup and redirect
            $this->showPopup("Purchase successful! Thank you for your order.", URLROOT . "/StorePageController/index");
        } else {
            // Show failure popup
            $this->showPopup("Failed to complete the purchase. Please try again.", URLROOT . "/CartController/viewCart");
        }
    }
    
    
    
    
    
}
