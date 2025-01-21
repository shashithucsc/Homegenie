document.addEventListener("DOMContentLoaded", loadInventory);

function loadInventory() {
    fetch('/store/app/controllers/fetchInventoryController.php')
        .then(response => response.json())
        .then(data => {
            const inventoryTable = document.getElementById('inventory-data');
            inventoryTable.innerHTML = '';
            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.item_name}</td>
                    <td>${item.quantity}</td>
                    <td>${item.item_id}</td>
                    <td>Rs. ${item.selling_price}</td>
                    <td>${item.category}</td>
                    <td>${item.added_date}</td>
                    <td>
                        <button class="update-btn" data-id="${item.item_id}" data-price="${item.selling_price}">Update</button>
                        <button class="remove-btn" data-id="${item.item_id}">Remove</button>
                    </td>
                `;
                inventoryTable.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching inventory:', error));
}

document.addEventListener('click', function(e) {
    if (e.target.matches('.update-btn')) {
        const itemId = e.target.dataset.id;
        const itemPrice = e.target.dataset.price;
        updateItem(itemId, itemPrice);
    }
    if (e.target.matches('.remove-btn')) {
        const itemId = e.target.dataset.id;
        removeItem(itemId);
    }
});

let selectedItemId;

function updateItem(itemId) {
    selectedItemId = itemId; 
    document.getElementById('updateModal').style.display = 'flex';
}

document.getElementById('updateConfirmBtn').addEventListener('click', () => {
    const newPrice = document.getElementById('newPrice').value;
    fetch(`/store/app/controllers/updateInventoryItemsController.php?id=${selectedItemId}&price=${newPrice}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadInventory();
                closeModals();
            } else {
                alert('Failed to update item.');
            }
        })
        .catch(error => console.error('Error updating item:', error));
});

document.getElementById('updateCancelBtn').addEventListener('click', closeModals);

function removeItem(itemId) {
    selectedItemId = itemId;
    document.getElementById('removeModal').style.display = 'flex';
}

document.getElementById('removeConfirmBtn').addEventListener('click', () => {
    fetch(`/store/app/controllers/removeInventoryItemsController.php?id=${selectedItemId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadInventory();
                closeModals();
            } else {
                alert('Failed to remove item.');
            }
        })
        .catch(error => console.error('Error removing item:', error));
});

document.getElementById('removeCancelBtn').addEventListener('click', closeModals);

function closeModals() {
    document.getElementById('updateModal').style.display = 'none';
    document.getElementById('removeModal').style.display = 'none';
}