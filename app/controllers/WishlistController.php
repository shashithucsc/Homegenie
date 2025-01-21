<?php
class WishlistController extends Controller {
    public function saveItem() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $item_id = $_POST['item_id'];

            
            $wishlistModel = $this->model('WishlistModel');
            if ($wishlistModel->saveItem($item_id, $_SESSION['user_id'])) {
                header('Location: ' . URLROOT . '/store');
            } else {
                die('Error saving item.');
            }
        } else {
            header('Location: ' . URLROOT . '/store');
        }
    }
}
?>
