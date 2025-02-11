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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>

    <div class="container">
        <div class="header9">
            <div class="search-container">
                <input type="text" placeholder="Search Inventory..." class="search-box" onkeyup="searchInventory()">
                <i class="fas fa-search search-icon"></i>
            </div>
            <a href="<?php echo URLROOT; ?>/InventoryController/add" class="add-item-btn">
                <i class="fas fa-plus"></i> Add Item
            </a>
            <div class="user-info">
                <div class="user-greeting">Hello, <?php echo htmlspecialchars($user_name); ?></div>
                <div class="user-avatar">
                    <img src="<?php echo URLROOT; ?>/public/images/<?php echo $profile_pic; ?>" alt="Profile">
                </div>
            </div>
        </div>

        <main>
            <section class="inventory-list">
                <div class="list-header">
                    <h2><i class="fas fa-boxes"></i> Inventory List</h2>
                    <div class="total-items"><?php echo count($data); ?> Items Found</div>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>ID</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php foreach ($data as $item): ?>
                                <tr>
                                    <td><?php echo $item->item_name; ?></td>
                                    <td><span class="quantity-badge"><?php echo $item->quantity; ?></span></td>
                                    <td>#<?php echo $item->item_id; ?></td>
                                    <td>Rs.<?php echo number_format($item->selling_price, 2); ?></td>
                                    <td><span class="category-tag"><?php echo $item->category; ?></span></td>
                                    <td><?php echo date('M d, Y', strtotime($item->added_date)); ?></td>
                                    <td>
                                        <a href="#" class="action-link update-btn" data-id="<?php echo $item->item_id; ?>" style="margin-right: 10px;">
                                            <i class="fas fa-edit"></i> Update
                                        </a>

                                        <a href="#" class="action-link remove-btn" data-id="<?php echo $item->item_id; ?>">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="no-items">
                                <td colspan="7">
                                    <i class="fas fa-box-open"></i>
                                    No items found in inventory
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Update Modal -->
                <div id="updateModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3><i class="fas fa-edit"></i> Update Price</h3>
                            <span class="close-modal">&times;</span>
                        </div>
                        <form id="updateForm" action="<?php echo URLROOT; ?>/InventoryController/update" method="POST">
                            <input type="hidden" name="item_id" id="updateItemId">
                            <div class="form-group">
                                <label for="updatePrice">New Price (LKR)</label>
                                <input type="number" name="price" id="updatePrice" step="0.01" required>
                            </div>
                            <div class="modal-actions">
                                <button type="submit" class="confirm-btn">
                                    <i class="fas fa-check"></i> Confirm
                                </button>
                                <button type="button" class="cancel-btn">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div id="deleteModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h3>
                            <span class="close-modal">&times;</span>
                        </div>
                        <form id="deleteForm" action="<?php echo URLROOT; ?>/InventoryController/delete" method="POST">
                            <input type="hidden" name="item_id" id="deleteItemId">
                            <p>Are you sure you want to permanently delete this item?</p>
                            <div class="modal-actions">
                                <button type="submit" class="confirm-btn danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                                <button type="button" class="cancel-btn">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <div class="sidebarR">
                <div class="filters-card">
                    <h3><i class="fas fa-filter"></i> Filters</h3>
                    <div class="filter-group">
                        <label class="filter-label">Category</label>
                        <select id="category" class="modern-select">
                            <option value="all">All Categories</option>
                            <option>Cleaning</option>
                            <option>Electricity</option>
                            <option>Painting</option>
                            <option>Masonary</option>
                            <option>Carpentary</option>
                            <option>Plumbing</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Price Range</label>
                        <select id="price" class="modern-select">
                            <option value="all">All Prices</option>
                            <option>1000+</option>
                            <option>500-999</option>
                            <option>0-499</option>
                        </select>
                    </div>
                </div>

                <div class="stats-card">
                    <h3><i class="fas fa-chart-line"></i> Statistics</h3>
                    <div class="stat-item">
                        <div class="stat-label">Total Stock Value</div>
                        <div class="stat-value">Rs. 1,234,567</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Low Stock Items</div>
                        <div class="stat-value">15 Items</div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-labels">
                            <span>Stock Capacity</span>
                            <span>75%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 75%"></div>
                        </div>
                    </div>
                </div>

                <div class="quick-actions">
                    <a href="<?php echo URLROOT; ?>/SupplierController/reports" class="action-card">
                        <i class="fas fa-file-invoice"></i>
                        <span>Generate Reports</span>
                    </a>
                    <a href="<?php echo URLROOT; ?>/SupplierController/manageOffers" class="action-card">
                        <i class="fas fa-tag"></i>
                        <span>Manage Offers</span>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Modal Handling
            const modals = {
                update: document.getElementById('updateModal'),
                delete: document.getElementById('deleteModal')
            };

            const openModal = (modal) => {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            };

            const closeModal = (modal) => {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            };

            // Update Modal
            document.querySelectorAll('.update-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.getElementById('updateItemId').value = btn.dataset.id;
                    openModal(modals.update);
                });
            });

            // Delete Modal
            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.getElementById('deleteItemId').value = btn.dataset.id;
                    openModal(modals.delete);
                });
            });

            // Close Modals
            document.querySelectorAll('.close-modal, .cancel-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    closeModal(modals.update);
                    closeModal(modals.delete);
                });
            });

            // Close on outside click
            window.addEventListener('click', (e) => {
                if (e.target.classList.contains('modal')) {
                    closeModal(modals.update);
                    closeModal(modals.delete);
                }
            });

            // Price Validation
            document.getElementById('updateForm').addEventListener('submit', (e) => {
                const price = parseFloat(document.getElementById('updatePrice').value);
                if (price <= 0 || isNaN(price)) {
                    e.preventDefault();
                    alert('Please enter a valid positive price');
                    document.getElementById('updatePrice').focus();
                }
            });
        });
    </script>
</body>
</html>