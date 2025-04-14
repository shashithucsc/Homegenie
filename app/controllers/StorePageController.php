<?php


class StorePageController extends Controller
{


    private $StorePagesModel;
    private $cartModel;

    public function __construct()
    {
        $this->StorePagesModel = $this->model('StorePagesModel');
        $this->cartModel = $this->model('CartModel');
    }


    public function index()
    {
        $storePagesModel = $this->model('StorePagesModel');
        $data = $storePagesModel->getPlumbingItems();
        $data1 = $storePagesModel->getSeasonalOffers();
        $this->view('supplier/homepage/index', ['items' => $data, 'data1' => $data1]);
    }


    public function contact()
    {
        $this->view('supplier/homepage/contact');
    }

    public function aboutUs()
    {
        $this->view('supplier/homepage/about');
    }

    public function navbar()
    {
        $this->view('navbar/navbar');
    }


    public function carpentry()
    {
        $storePagesModel = $this->model('StorePagesModel');
        $items = $storePagesModel->getCarpentryItems();
        $this->view('supplier/homepage/carpentry', ['items' => $items]);
    }
    public function electricity()
    {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getElectricityItems();
        $this->view('supplier/homepage/electricity', ['items' => $items]);
    }

    public function masonary()
    {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getMasonaryItems();
        $this->view('supplier/homepage/masonary', ['items' => $items]);
    }

    public function painting()
    {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getPaintingItems();
        $this->view('supplier/homepage/painting', ['items' => $items]);
    }

    public function cleaning()
    {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getCleaningItems();
        $this->view('supplier/homepage/cleaning', ['items' => $items]);
    }

    public function wishlist()
    {
        if (!isset($_SESSION['user_id'])) {
            die("User not logged in.");
        }

        $user_id = $_SESSION['user_id'];

        $wishList = $this->model(model: 'StorePagesModel');
        $items = $wishList->getSavedItem($user_id); // Pass user_id


        $this->view('supplier/homepage/wishList', ['items' => $items]);
    }

    public function removeFromWishlist()
    {
        if (!isset($_SESSION['user_id'])) {
            die("User not logged in.");
        }

        if (!isset($_POST['item_id'])) {
            $this->showPopup("Item ID not provided.", URLROOT . "/StorePagesController/wishlist");
            return;
        }

        $user_id = $_SESSION['user_id'];
        $item_id = $_POST['item_id'];

        if ($this->StorePagesModel->removeSavedItem($user_id, $item_id)) {
            $this->showPopup("Item removed from wishlist successfully!", URLROOT . "/StorePagesController/wishlist");
        } else {
            $this->showPopup("Failed to remove item from wishlist.", URLROOT . "/StorePagesController/wishlist");
        }
    }


    public function addToWishlist()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id'])) {
                die("User not logged in.");
            }

            if (!isset($_POST['item_id'])) {
                $this->showPopup("Missing required form fields.", URLROOT . "/StorePagesController");
                return;
            }

            $user_id = $_SESSION['user_id'];
            $item_id = $_POST['item_id'];

            $result = $this->StorePagesModel->saveItem($user_id, $item_id);

            if ($result === 'saved') {
                $this->showPopup("Item added to wishlist!", URLROOT . "/StorePagesController");
            } elseif ($result === 'exists') {
                $this->showPopup("Item is already in your wishlist!", URLROOT . "/StorePagesController");
            } else {
                $this->showPopup("Something went wrong. Please try again.", URLROOT . "/StorePagesController");
            }
        } else {
            die("Invalid request.");
        }
    }




    //cart functions
    public function addToCart()
    {
        if (!isset($_SESSION['user_id'])) {
            die('Error: User not logged in.');
        }

        $customerId = $_SESSION['user_id'];
        $itemId = $_POST['item_id'];
        $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1; // Default to 1 if not set

        if ($quantity <= 0) {
            $this->showPopup("Invalid quantity.", URLROOT . "/StorePagesController");
            return;
        }

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
            $this->showPopup("Item(s) added to cart successfully!", URLROOT . "/StorePageController/viewCart");
        } else {
            $this->showPopup("Failed to add items to cart.", URLROOT . "/StorePageController/viewCart");
        }
    }

    public function removeItem($cartItemId)
    {
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
                $this->showPopup("Item removed from cart successfully!", URLROOT . "/StorePageController/viewCart");
            } else {
                $this->showPopup("Failed to remove item.", URLROOT . "/StorePageController/viewCart");
            }
        }
    }

    public function updateItemQuantity()
    {
        if (!isset($_SESSION['user_id'])) {
            die('Error: User not logged in.');
        }

        $cartItemId = $_POST['cart_item_id'];
        $newQuantity = (int) $_POST['new_quantity'];

        // Get item details
        $cartItem = $this->cartModel->getCartItemById($cartItemId);
        $itemId = $cartItem->item_id;
        $availableQuantity = $this->cartModel->getAvailableQuantity($itemId);

        if ($newQuantity <= $availableQuantity) {
            // Update cart and inventory
            $this->cartModel->updateCartQuantity($cartItemId, $newQuantity);
            $this->cartModel->updateInventoryLevel($itemId, $availableQuantity - $newQuantity);
            $this->showPopup("Item quantity updated successfully!", URLROOT . "/StorePageController/viewCart");
        } else {
            $this->showPopup("Not enough stock available.", URLROOT . "/StorePageController/viewCart");
        }
    }


    public function viewCart()
    {
        $customerId = $_SESSION['user_id'];

        $cartItems = $this->cartModel->getCartItemsByUserId($customerId);
        $total = 0;

        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->selling_price;
        }

        $this->view('supplier/homepage/cart', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }


    public function checkout()
    {
        $customerId = $_SESSION['user_id']; // Assuming user_id is set in session
        $cartItems = $this->cartModel->getCartItemsByUserId($customerId);

        $totalItems = 0;
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $totalItems += $item->quantity;
            $subtotal += $item->quantity * $item->selling_price;
        }

        $this->view('supplier/homepage/V_checkOutpage', [
            'total_items' => $totalItems,
            'subtotal' => $subtotal
        ]);
    }


    public function confirmOrder()
    {
        if (!isset($_SESSION['user_id'])) {
            die('Error: User not logged in.');
        }

        $customerId = $_SESSION['user_id'];

        // Fetch cart items for the user
        $cartItems = $this->cartModel->getCartItemsByUserId($customerId);

        if (empty($cartItems)) {
            $this->showPopup("Your cart is empty.", URLROOT . "/StorePageController/viewCart");
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
            $this->showPopup("Missing payment method or delivery address.", URLROOT . "/StorePageController/viewCart");
            return;
        }

        // Extract supplier ID (assumes all items belong to the same supplier)
        $supplierId = $cartItems[0]->supplier_id ?? null;

        if (!$supplierId) {
            $this->showPopup("Error: Supplier not found for items in the cart.", URLROOT . "/StorePageController/viewCart");
            return;
        }

        // Ensure the supplier exists
        if (!$this->cartModel->isSupplierValid($supplierId)) {
            $this->showPopup("Error: Invalid supplier.", URLROOT . "/StorePageController/viewCart");
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
            $this->showPopup("Order creation failed. Please try again.", URLROOT . "/StorePageController/viewCart");
        }
    }

    public function myOrders()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . URLROOT . "/StorePageController/index");
        }

        $userId = $_SESSION['user_id'];
        $orders = $this->StorePagesModel->getMyorders($userId);

        $data = [
            'orders' => $orders
        ];

        $this->view('supplier/homepage/myOrders', $data);
    }


    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $searchQuery = filter_input(INPUT_POST, 'search_query', FILTER_SANITIZE_STRING);
            if (!empty($searchQuery)) {
                $items = $this->StorePagesModel->searchItems($searchQuery);
                $data = ['items' => $items];
                $this->view('supplier/homepage/searchPage', $data);
            } else {
                header('Location: ' . URLROOT . '/StorePageController/index');
                exit();
            }
        } else {
            header('Location: ' . URLROOT . '/StorePageController/index');
            exit();
        }
    }


    public function addReview()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $item_id = $_POST['item_id'];
        $user_id = $_SESSION['user_id']; // assuming you use sessions
        $rating = $_POST['rating'];
        $comment = trim($_POST['comment']);

        $this->StorePagesModel->insertReview($item_id, $user_id, $rating, $comment);
        $this->showPopup("Thank you for your feedback!", URLROOT . "/StorePageController");
    }
}



    private function showPopup($message, $redirectUrl)
    {
        // Pass message and redirect URL to the view
        $data = ['message' => $message, 'redirectUrl' => $redirectUrl];
        $this->view('supplier/homepage/cartElements/popup', $data);
    }


}