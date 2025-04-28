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



    public function support()
    {
        $data = [
            'faqs' => $this->StorePagesModel->getFAQs() ?? []
        ];
        $this->view('supplier/homepage/support', $data);
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
        $cleaningModel = $this->model('StorePagesModel');
        $itmes = $cleaningModel->getCleaningItems();
        $this->view('supplier/homepage/cleaning', ['items' => $itmes]);

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





   
    public function wishlist()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . URLROOT . "/StorePageController/index");

            return;
        }

        $user_id = $_SESSION['user_id'];

        $wishList = $this->model(model: 'StorePagesModel');
        $items = $wishList->getSavedItem($user_id);


        $this->view('supplier/homepage/wishList', ['items' => $items]);
    }

    public function removeFromWishlist()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . URLROOT . "/LoginController/index");
            return;
        }

        if (!isset($_POST['item_id'])) {
            $this->showPopup("Item ID not provided.", URLROOT . "/StorePageController/wishlist");
            return;
        }

        $user_id = $_SESSION['user_id'];
        $item_id = $_POST['item_id'];

        if ($this->StorePagesModel->removeSavedItem($user_id, $item_id)) {
            $this->showPopup("Item removed from wishlist successfully!", URLROOT . "/StorePageController/wishlist");
        } else {
            $this->showPopup("Failed to remove item from wishlist.", URLROOT . "/StorePageController/wishlist");
        }
    }


    public function addToWishlist()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header("Location: " . URLROOT . "/LoginController/index");
                return;
            }

            if (!isset($_POST['item_id'])) {
                $this->showPopup("Missing required form fields.", URLROOT . "/StorePageController");
                return;
            }

            $user_id = $_SESSION['user_id'];
            $item_id = $_POST['item_id'];

            $result = $this->StorePagesModel->saveItem($user_id, $item_id);

            if ($result === 'saved') {
                $this->showPopup("Item added to wishlist!", URLROOT . "/StorePageController");
            } elseif ($result === 'exists') {
                $this->showPopup("Item is already in your wishlist!", URLROOT . "/StorePageController");
            } else {
                $this->showPopup("Something went wrong. Please try again.", URLROOT . "/StorePageController");
            }
        } else {
            die("Invalid request.");
        }
    }






    
    public function viewCart()
    {
        $customerId = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getCartItemsByUserId($customerId);
        $total = 0;
        $supplierIds = [];

        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->selling_price;
            $supplierIds[$item->supplier_id] = true;
        }

        $numSuppliers = count($supplierIds);

        $this->view('supplier/homepage/cart', [
            'cartItems' => $cartItems,
            'total' => $total,
            'numSuppliers' => $numSuppliers
        ]);
    }

    public function addToCart()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . URLROOT . "/LoginController/index");
            return;
        }

        $customerId = $_SESSION['user_id'];
        $itemId = $_POST['item_id'];
        $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

        if ($quantity <= 0) {
            $this->showPopup("Invalid quantity.", URLROOT . "/StorePageController");
            return;
        }


        $supplierId = $this->cartModel->getSupplierIdByItemId($itemId);

        if (!$supplierId) {
            die('Error: Supplier ID not found.');
        }

        
        $availableQuantity = $this->cartModel->getAvailableQuantity($itemId);
        if ($quantity > $availableQuantity) {
            $this->showPopup("Not enough stock available.", URLROOT . "/StorePagesController");
            return;
        }

        
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
            header("Location: " . URLROOT . "/LoginController/index");
            return;
        }

       
        $cartItem = $this->cartModel->getCartItemById($cartItemId);
        if ($cartItem) {
            $itemId = $cartItem->item_id;
            $quantity = $cartItem->quantity;

            
            if ($this->cartModel->removeItemFromCart($cartItemId)) {
                $availableQuantity = $this->cartModel->getAvailableQuantity($itemId);
                $newQuantity = $availableQuantity + $quantity; 
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
            header("Location: " . URLROOT . "/StorePageController/viewCart");
            return;
        }

        $cartItemId = $_POST['cart_item_id'];
        $newQuantity = (int) $_POST['new_quantity'];

        
        $cartItem = $this->cartModel->getCartItemById($cartItemId);
        $itemId = $cartItem->item_id;
        $availableQuantity = $this->cartModel->getAvailableQuantity($itemId);

        if ($newQuantity <= $availableQuantity) {
           
            $this->cartModel->updateCartQuantity($cartItemId, $newQuantity);
            $this->cartModel->updateInventoryLevel($itemId, $availableQuantity - $newQuantity);
            $this->showPopup("Item quantity updated successfully!", URLROOT . "/StorePageController/viewCart");
        } else {
            $this->showPopup("Not enough stock available.", URLROOT . "/StorePageController/viewCart");
        }
    }


    public function checkout()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . URLROOT . "/StorePageController/viewCart");
            return;
        }

        $userId = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getCartItemsByUserId($userId);

        if (empty($cartItems)) {
            $this->showPopup("Your cart is empty.", URLROOT . "/StorePageController/viewCart");
            return;
        }

        $totalItems = 0;
        $subtotal = 0;
        $supplierIds = [];
        $supplierTotals = [];
        $supplierDeliveryFees = [];
        $supplierGrandTotals = [];

        foreach ($cartItems as $item) {
            $totalItems += $item->quantity;
            $subtotal += $item->quantity * $item->selling_price;
            $supplierIds[$item->supplier_id] = true;

            if (!isset($supplierTotals[$item->supplier_id])) {
                $supplierTotals[$item->supplier_id] = 0;
            }
            $supplierTotals[$item->supplier_id] += $item->quantity * $item->selling_price;
        }

        $numSuppliers = count($supplierIds);

        
        $grandTotal = isset($_POST['grand_total']) ? floatval($_POST['grand_total']) : $subtotal;
        $deliveryFee = isset($_POST['delivery_fee']) ? floatval($_POST['delivery_fee']) : 0;

       
        $supplierData = json_decode($_POST['supplier_totals'], true);
        if ($supplierData) {
            $supplierTotals = $supplierData['totals'];
            $supplierDeliveryFees = $supplierData['deliveryFees'];
            $supplierGrandTotals = $supplierData['grandTotals'];
        }

        $this->view('supplier/homepage/V_checkOutPage', [
            'total_items' => $totalItems,
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'num_suppliers' => $numSuppliers,
            'supplier_ids' => array_keys($supplierIds),
            'grand_total' => $grandTotal,
            'supplier_totals' => $supplierTotals,
            'supplier_delivery_fees' => $supplierDeliveryFees,
            'supplier_grand_totals' => $supplierGrandTotals
        ]);
    }





    public function confirmOrder()
    {
        if (!isset($_SESSION['user_id'])) {
            die('Error: User not logged in.');
        }

        $customerId = $_SESSION['user_id'];

        $grandTotal = $_POST['grand_total'] ?? null;
        $paymentMethod = $_POST['payment_method'] ?? null;
        $deliveryAddress = $_POST['delivery_address'] ?? null;
        $supplierIds = isset($_POST['supplier_ids']) ? json_decode($_POST['supplier_ids'], true) : [];
        $supplierTotals = isset($_POST['supplier_totals']) ? json_decode($_POST['supplier_totals'], true) : [];
        $supplierDeliveryFees = isset($_POST['supplier_delivery_fees']) ? json_decode($_POST['supplier_delivery_fees'], true) : [];
        $supplierGrandTotals = isset($_POST['supplier_grand_totals']) ? json_decode($_POST['supplier_grand_totals'], true) : [];

        if (!$grandTotal || !$paymentMethod || !$deliveryAddress || empty($supplierIds) || empty($supplierTotals)) {
            $this->showPopup("Missing order details.", URLROOT . "/StorePageController/viewCart");
            return;
        }

        if ($paymentMethod === 'cod') {
            
            foreach ($supplierIds as $supplierId) {
                if (!isset($supplierTotals[$supplierId]) || !isset($supplierDeliveryFees[$supplierId])) {
                    $this->showPopup("Missing totals for supplier ID $supplierId.", URLROOT . "/StorePageController/viewCart");
                    return;
                }

                $itemTotal = (float) $supplierTotals[$supplierId];
                $deliveryFee = (float) $supplierDeliveryFees[$supplierId];
                $supplierGrandTotal = $itemTotal + $deliveryFee;

                
                $saleId = $this->cartModel->createOrder($customerId, $supplierGrandTotal, $paymentMethod, $deliveryAddress, $supplierId, $deliveryFee);

                if (!$saleId) {
                    $this->showPopup("Order creation failed for supplier ID $supplierId.", URLROOT . "/StorePageController/viewCart");
                    return;
                }

               
                $cartItems = $this->cartModel->getCartItemsByUserIdAndSupplierId($customerId, $supplierId);

                if (empty($cartItems)) {
                    $this->showPopup("No cart items found for supplier ID $supplierId.", URLROOT . "/StorePageController/viewCart");
                    return;
                }

                foreach ($cartItems as $item) {
                    $this->cartModel->addOrderItem($saleId, $item->item_id, $item->quantity, $item->selling_price, $supplierId);
                }
            }

           
            $this->cartModel->clearCart($customerId);

            $this->showPopup("Order placed successfully!", URLROOT . "/StorePageController/index");

        } elseif ($paymentMethod === 'card') {
           
            $_SESSION['pending_supplier_ids'] = $supplierIds;
            $_SESSION['pending_supplier_totals'] = $supplierTotals;
            $_SESSION['pending_supplier_delivery_fees'] = $supplierDeliveryFees;
            $_SESSION['pending_supplier_grand_totals'] = $supplierGrandTotals;
            $_SESSION['pending_grand_total'] = $grandTotal;
            $_SESSION['pending_delivery_address'] = $deliveryAddress;
            $_SESSION['pending_customer_id'] = $customerId;

            $this->view('supplier/homepage/paymentGateway', [
                'grand_total' => $grandTotal,
                'delivery_address' => $deliveryAddress
            ]);
        }
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
            $user_id = $_SESSION['user_id'];
            $rating = $_POST['rating'];
            $comment = trim($_POST['comment']);

            $this->StorePagesModel->insertReview($item_id, $user_id, $rating, $comment);
            $this->showPopup("Thank you for your feedback!", URLROOT . "/StorePageController");
        }
    }


    public function cardPaymentPage()
    {
        if (!isset($_SESSION['user_id'])) {
            die("Unauthorized access.");
        }

        $total = $_GET['total'] ?? null;
        $address = $_GET['address'] ?? null;

        if (!$total || !$address) {
            $this->showPopup("Missing payment data", URLROOT . "/StorePageController/viewCart");
            return;
        }

       
        $data = [
            'grand_total' => $total,
            'delivery_address' => $address
        ];

        $this->view('supplier/homepage/paymentGateway', $data);
    }

    public function processPayment()
    {
        if (!isset($_SESSION['user_id'])) {
            die('Error: User not logged in.');
        }

    $customerId = $_SESSION['user_id'];
    $grandTotal = $_SESSION['pending_grand_total'] ?? null;
    $deliveryAddress = $_SESSION['pending_delivery_address'] ?? null;
    $supplierIds = $_SESSION['pending_supplier_ids'] ?? [];
    $supplierTotals = $_SESSION['pending_supplier_totals'] ?? [];
    $supplierDeliveryFees = $_SESSION['pending_supplier_delivery_fees'] ?? [];
    $supplierGrandTotals = $_SESSION['pending_supplier_grand_totals'] ?? [];

    if (!$grandTotal || !$deliveryAddress || empty($supplierIds) || empty($supplierTotals)) {
        $this->showPopup("Payment failed: missing session data.", URLROOT . "/StorePageController/viewCart");
        return;
    }

  
    foreach ($supplierIds as $supplierId) {
        if (!isset($supplierTotals[$supplierId]) || !isset($supplierDeliveryFees[$supplierId])) {
            $this->showPopup("Missing totals for supplier ID $supplierId.", URLROOT . "/StorePageController/viewCart");
            return;
        }

        $itemTotal = (float)$supplierTotals[$supplierId];
        $deliveryFee = (float)$supplierDeliveryFees[$supplierId];
        $supplierGrandTotal = $itemTotal + $deliveryFee;

      
        $saleId = $this->cartModel->createOrder($customerId, $supplierGrandTotal, 'card', $deliveryAddress, $supplierId, $deliveryFee);

        if (!$saleId) {
            $this->showPopup("Order creation failed for supplier ID $supplierId.", URLROOT . "/StorePageController/viewCart");
            return;
        }

       
        $cartItems = $this->cartModel->getCartItemsByUserIdAndSupplierId($customerId, $supplierId);

        if (empty($cartItems)) {
            $this->showPopup("No cart items found for supplier ID $supplierId.", URLROOT . "/StorePageController/viewCart");
            return;
        }

        foreach ($cartItems as $item) {
            $this->cartModel->addOrderItem($saleId, $item->item_id, $item->quantity, $item->selling_price, $supplierId);
        }
    }

    
    $this->cartModel->clearCart($customerId);

   
    unset($_SESSION['pending_grand_total']);
    unset($_SESSION['pending_delivery_address']);
    unset($_SESSION['pending_supplier_ids']);
    unset($_SESSION['pending_supplier_totals']);
    unset($_SESSION['pending_supplier_delivery_fees']);
    unset($_SESSION['pending_supplier_grand_totals']);

        $this->showPopup("Payment Successful! Order placed.", URLROOT . "/StorePageController/index");
    }




    
    private function showPopup($message, $redirectUrl)
    {

        $data = ['message' => $message, 'redirectUrl' => $redirectUrl];
        $this->view('supplier/homepage/cartElements/popup', $data);
    }

    public function submitContactIssue() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id'])) {
                $this->showPopup("Please login to submit an issue.", URLROOT . "/StorePageController/support");
                return;
            }

            $title = trim($_POST['issue-title']);
            $description = trim($_POST['issue-description']);

            if (empty($title) || empty($description)) {
                $this->showPopup("Please fill in all fields.", URLROOT . "/StorePageController/support");
                return;
            }

            if ($this->StorePagesModel->insertContactIssue($_SESSION['user_id'], $title, $description)) {
                $this->showPopup("Issue submitted successfully!", URLROOT . "/StorePageController/support");
            } else {
                $this->showPopup("Failed to submit issue. Please try again.", URLROOT . "/StorePageController/support");
            }
        } else {
            header("Location: " . URLROOT . "/StorePageController/support");
        }
    }

}