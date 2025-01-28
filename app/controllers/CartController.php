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
    
        $customerId = $_SESSION['user_id'];
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
        if ($this->cartModel->addItemToCart($customerId, $itemId, $quantity, $supplierId)) {
            $this->cartModel->updateInventoryLevel($itemId, $availableQuantity - $quantity);
            $this->showPopup("Item(s) added to cart successfully!", URLROOT . "/CartController/viewCart");
        } else {
            $this->showPopup("Failed to add items to cart.", URLROOT . "/CartController/viewCart");
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
        $customerId = $_SESSION['user_id'];
    
        $cartItems = $this->cartModel->getCartItemsByUserId( $customerId);
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
        $customerId = $_SESSION['user_id']; // Assuming user_id is set in session
        $cartItems = $this->cartModel->getCartItemsByUserId( $customerId);
        
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
    
        $customerId = $_SESSION['user_id'];
    
        // Fetch cart items for the user
        $cartItems = $this->cartModel->getCartItemsByUserId($customerId);
    
        if (empty($cartItems)) {
            $this->showPopup("Your cart is empty.", URLROOT . "/CartController/viewCart");
            return;
        }
    
        $totalAmount = 0;
    
        foreach ($cartItems as $item) {
            $totalAmount += $item->quantity * $item->selling_price;
        }
    
        // Validate payment and delivery details
        $paymentMethod = $_POST['payment_method'] ?? null;
        $deliveryAddress = $_POST['delivery_address'] ?? null;
    
        if (!$paymentMethod || !$deliveryAddress) {
            $this->showPopup("Missing payment method or delivery address.", URLROOT . "/CartController/viewCart");
            return;
        }
    
        // Extract supplier ID (assumes all items belong to the same supplier)
        $supplierId = $cartItems[0]->supplier_id ?? null;
    
        if (!$supplierId) {
            $this->showPopup("Error: Supplier not found for items in the cart.", URLROOT . "/CartController/viewCart");
            return;
        }
    
        // Ensure the supplier exists
        if (!$this->cartModel->isSupplierValid($supplierId)) {
            $this->showPopup("Error: Invalid supplier.", URLROOT . "/CartController/viewCart");
            return;
        }
    
        // Create the order
        $saleId = $this->cartModel->createOrder($customerId, $totalAmount, $paymentMethod, $deliveryAddress, $supplierId);
    
        if ($saleId) {
            // Add each item to the sales_items table
            foreach ($cartItems as $item) {
                $this->cartModel->addOrderItem($saleId, $item->item_id, $item->quantity, $item->selling_price, $supplierId);
            }
    
            // Clear the cart
            $this->cartModel->clearCart($customerId);
    
            // Success popup
            $this->showPopup("Purchase successful! Thank you for your order.", URLROOT . "/StorePageController/index");
        } else {
            // Failure popup
            $this->showPopup("Order creation failed. Please try again.", URLROOT . "/CartController/viewCart");
        }
    }
    
        
    
    
    
    
    
    
}
