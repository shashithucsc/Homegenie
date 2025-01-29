<?php


$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; 
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png'; 
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/inventory.css">
   
    

</head>

<body>
    
<?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>
 

    <div class="container">
        <div class = "header9">
            <input type="text" placeholder="Search Inventory..." class="search-box" onkeyup="searchInventory()">
            <a href="<?php echo URLROOT; ?>/InventoryController/add" class="add-item-btn">+ ADD item</a>
            <div class="user-info">
            <span>Hello, <?php echo htmlspecialchars($user_name); ?></span>
            </div>
            <br>
            <h2>Welcome to Inventory Management</h2>
        </div>

        <main>
            <section class="inventory-list">
                <h3>Inventory List</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>ID</th>
                            <th>Selling Price</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php foreach ($data as $item): ?>
                                <tr>
                                    <td><?php echo $item->item_name; ?></td>
                                    <td><?php echo $item->quantity; ?></td>
                                    <td><?php echo $item->item_id; ?></td>
                                    <td><?php echo $item->selling_price; ?></td>
                                    <td><?php echo $item->category; ?></td>
                                    <td><?php echo $item->added_date; ?></td>
                                    <td>
                                        <button class="update-btn" data-id="<?php echo $item->item_id; ?>">Update</button>
                                       
                                        <button class="remove-btn" data-id="<?php echo $item->item_id; ?>">Delete</button>
                                    </td>

                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No items found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
               
                <div id="updateModal" class="modal" style="display: none;">
                    <div class="modal-content">
                        <h3>Update Price</h3>
                        <form id="updateForm" action="<?php echo URLROOT; ?>/InventoryController/update"
                            method="POST">
                            <input type="hidden" name="item_id" id="updateItemId">
                            <label for="updatePrice">New Price:</label>
                            <input type="number" name="price" id="updatePrice" required>
                            <div class="modal-actions">
                                <button type="submit" class="confirm-btn">Confirm</button>
                                <button type="button" class="cancel-btn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

               
                <div id="deleteModal" class="modal" style="display: none;">
                    <div class="modal-content">
                        <h3>Are you sure you want to delete this item?</h3>
                        <form id="deleteForm" action="<?php echo URLROOT; ?>/InventoryController/delete"
                            method="POST">
                            <input type="hidden" name="item_id" id="deleteItemId">
                            <div class="modal-actions">
                                <button type="submit" class="confirm-btn">Yes</button>
                                <button type="button" class="cancel-btn">No</button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", () => {
    const updateButtons = document.querySelectorAll(".update-btn");
    const removeButtons = document.querySelectorAll(".remove-btn");
    const updateModal = document.getElementById("updateModal");
    const deleteModal = document.getElementById("deleteModal");
    const cancelButtons = document.querySelectorAll(".cancel-btn");

    const updateItemId = document.getElementById("updateItemId");
    const deleteItemId = document.getElementById("deleteItemId");
    const updatePrice = document.getElementById("updatePrice"); 

  
    updateButtons.forEach(button => {
        button.addEventListener("click", () => {
            updateItemId.value = button.getAttribute("data-id");
            updateModal.style.display = "flex";
        });
    });

   
    removeButtons.forEach(button => {
        button.addEventListener("click", () => {
            deleteItemId.value = button.getAttribute("data-id");
            deleteModal.style.display = "flex";
        });
    });

    
    cancelButtons.forEach(button => {
        button.addEventListener("click", () => {
            updateModal.style.display = "none";
            deleteModal.style.display = "none";
        });
    });

    
    const updateForm = document.getElementById("updateForm");
    updateForm.addEventListener("submit", (event) => {
        const price = parseFloat(updatePrice.value);
        if (price <= 0) {
            event.preventDefault(); 
            alert("Price must be a positive value greater than zero.");
        }
    });
});

                </script>

            </section>

            <aside class="sidebarR">
                <div class="filters">
                    <h4>Inventory Filters</h4>
                    <label for="category">Filter by category</label>
                    <select id="category">
                        <option>Cleaning</option>
                        <option>Electricity</option>
                        <option>Painting</option>
                        <option>Masonary</option>
                        <option>Carpentary</option>
                        <option>Plumbing</option>
                    </select>

                    <label for="price">Filter by price</label>
                    <select id="price">
                        <option>1000+</option>
                        <option>500-999</option>
                        <option>0-499</option>
                    </select>
                </div>

                <div class="statistics">
                    <h4>Inventory Statistics</h4>
                    <br>
                    <div class="para">Purchased Items: 678</div>
                    <br>
                    <div class="para">Sold item: 89</div>
                    <div class="progress-bar">
                        <div class="progress" style="width: 70%"></div>
                    </div>
                </div>

                
                

                <a href="<?php echo URLROOT; ?>/SupplierController/reports">
                <button class="reports-btn">Reports</button>
                </a>

                <a href="<?php echo URLROOT; ?>/SupplierController/manageOffers">
                <button class="reports-btn">Manage Offers</button>
                </a>

            </aside>
        </main>
    </div>


    <div id="updateModal" class="modal">
        <div class="modal-content">
            <h3>Update Item</h3>
            <label for="newPrice">Enter New Price:</label>
            <input type="number" id="newPrice" placeholder="Enter price">
            <button id="updateConfirmBtn">Update</button>
            <button id="updateCancelBtn">Cancel</button>
        </div>
    </div>


    <div id="removeModal" class="modal">
        <div class="modal-content">
            <h3>Confirm Removal</h3>
            <p>Are you sure you want to remove this item?</p>
            <button id="removeConfirmBtn">Remove</button>
            <button id="removeCancelBtn">Cancel</button>
        </div>
    </div>


</body>

</html>