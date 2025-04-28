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
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['profile_pic']); ?>"
                        alt="Profile Picture" class="profile-pic">
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
                                        <button class="action-btn update-btn" data-id="<?php echo $item->item_id; ?>"
                                            data-price="<?php echo $item->selling_price; ?>"
                                            data-quantity="<?php echo $item->quantity; ?>" style="margin-right: 10px;">
                                            <i class="fas fa-edit"></i> Update
                                        </button>

                                        <button class="action-btn remove-btn" data-id="<?php echo $item->item_id; ?>">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
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


                <div id="updateModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3><i class="fas fa-edit"></i> Update Price</h3>
                            <span class="close-modal">&times;</span>
                        </div>
                        <form id="updateForm" action="<?php echo URLROOT; ?>/InventoryController/update" method="POST">
                            <input type="hidden" name="item_id" id="updateItemId">

                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="updateQuantity">New Quantity</label>
                                <input type="number" name="quantity" id="updateQuantity" min="0" required>
                            </div>

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
                            <option value="Cleaning">Cleaning</option>
                            <option value="Electricity">Electricity</option>
                            <option value="Painting">Painting</option>
                            <option value="Masonary">Masonary</option>
                            <option value="Carpentary">Carpentary</option>
                            <option value="Plumbing">Plumbing</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Price Range</label>
                        <select id="price" class="modern-select">
                            <option value="all">All Prices</option>
                            <option value="1000+">1000+</option>
                            <option value="5000+">5000+</option>
                            <option value="0-999">0-999</option>
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


            document.querySelectorAll('.update-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.getElementById('updateItemId').value = btn.dataset.id;
                    document.getElementById('updatePrice').value = btn.dataset.price;
                    document.getElementById('updateQuantity').value = btn.dataset.quantity;
                    openModal(modals.update);
                });
            });


            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.getElementById('deleteItemId').value = btn.dataset.id;
                    openModal(modals.delete);
                });
            });


            document.querySelectorAll('.close-modal, .cancel-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    closeModal(modals.update);
                    closeModal(modals.delete);
                });
            });


            window.addEventListener('click', (e) => {
                if (e.target.classList.contains('modal')) {
                    closeModal(modals.update);
                    closeModal(modals.delete);
                }
            });


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


    <script>
        function searchInventory() {
            const input = document.querySelector('.search-box');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('.inventory-list table tbody tr');

            rows.forEach(row => {
                const itemName = row.querySelector('td:nth-child(1)');
                if (!itemName) return;

                const text = itemName.textContent.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const categoryFilter = document.getElementById('category');
            const priceFilter = document.getElementById('price');

            categoryFilter.addEventListener('change', filterInventory);
            priceFilter.addEventListener('change', filterInventory);
        });

        function filterInventory() {
            const selectedCategory = document.getElementById('category').value;
            const selectedPrice = document.getElementById('price').value;

            const rows = document.querySelectorAll('.inventory-list table tbody tr');

            rows.forEach(row => {
                const categoryCell = row.querySelector('td:nth-child(5)');
                const priceCell = row.querySelector('td:nth-child(4)');

                if (!categoryCell || !priceCell) return;

                const categoryText = categoryCell.textContent.trim();
                const priceValue = parseFloat(priceCell.textContent.replace('Rs.', '').replace(',', ''));

                let categoryMatch = selectedCategory === 'all' || categoryText === selectedCategory;

                let priceMatch = false;
                if (selectedPrice === 'all') {
                    priceMatch = true;
                } else if (selectedPrice === '1000+') {
                    priceMatch = priceValue >= 1000;
                } else if (selectedPrice >= '5000+') {
                    priceMatch = priceValue >= 5000 && priceValue <= 1000;
                } else if (selectedPrice === '0-999') {
                    priceMatch = priceValue >= 0 && priceValue <= 999;
                }

                if (categoryMatch && priceMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>


</body>

</html>