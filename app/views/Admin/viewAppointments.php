<?php

$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; 
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png'; 
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

require_once APPROOT . '/views/Admin/AdminSideBar.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/AdminManageUsers.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Users</title>

</head>

<body>
    
    <section class="main">
        <div class="top">
            <div class="welcome">
                <span class="text">
                    <h3>Manage Users</h3>
                </span>
            </div>
            <div class="time" id="clock">
            </div>
        </div>
        <div class="table" id="customers_table">
            <section class="table-header">
                <h1>Users</h1>
                <div class="input-group">
                    <input type="search" placeholder="Search ..." id="searchInput">
                    <i class='bx bx-search'></i>
                </div>
            </section>
            <section class="table-body">
                <table>
                    <thead>
                        <tr>
                            <th>Appointment ID</th>
                            <th>Customer ID</th>
                            <th>Service Provider ID</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Cost</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($data['appointments']) && count($data['appointments']) > 0) : ?>
                            <?php foreach($data['appointments'] as $appointment) : ?>
                                <?php
                                $displayStatus = '';
                                if ($appointment->finish_status == 'complete') {
                                    $displayStatus = 'Completed';
                                } elseif ($appointment->quotation_status == 'approved') {
                                    $displayStatus = 'Pending Completion';
                                } elseif ($appointment->appointment_status == 'approved') {
                                    $displayStatus = 'Pending Payment';
                                } elseif ($appointment->appointment_status == 'pending') {
                                    $displayStatus = 'Pending Approval';
                                }

                                $ratingDisplay = $appointment->rating == 0 ? 'Not Rated' : $appointment->rating;
                                $costDisplay = $appointment->cost == 0 ? 'Not Paid' : $appointment->cost;       
                                ?>  
                                <tr>
                                    <td><?php echo $appointment->appointment_id; ?></td>
                                    <td><?php echo $appointment->customer_id; ?></td>
                                    <td><?php echo $appointment->service_provider_id; ?></td>
                                    <td><?php echo $appointment->description; ?></td>
                                    <td><?php echo $appointment->appointment_date; ?></td>
                                    <td><?php echo $appointment->appointment_time; ?></td>
                                    <td><?php echo $appointment->location; ?></td>
                                    <td><?php echo $displayStatus; ?></td>
                                    <td><?php echo $costDisplay; ?></td>
                                    <td><?php echo $ratingDisplay; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan='10'>No data found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </section>
    <script src="<?php echo URLROOT; ?>/public/js/clock.js"></script>
    <script src="<?php echo URLROOT; ?>/public/js/script-users.js"></script>
    
    <!-- <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });

        // Table sorting functionality
        const table = document.querySelector('table');
        const headers = table.querySelectorAll('th');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        headers.forEach((header, index) => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => {
                // Remove active class from all headers
                headers.forEach(h => h.classList.remove('active', 'asc', 'desc'));
                
                // Add active class to clicked header
                header.classList.add('active');
                
                // Determine sort direction
                const isAsc = !header.classList.contains('asc');
                header.classList.add(isAsc ? 'asc' : 'desc');
                
                // Sort the rows
                const sortedRows = rows.sort((a, b) => {
                    const aValue = a.children[index].textContent.trim();
                    const bValue = b.children[index].textContent.trim();
                    
                    // Check if the values are numbers
                    const aNum = parseFloat(aValue);
                    const bNum = parseFloat(bValue);
                    
                    if (!isNaN(aNum) && !isNaN(bNum)) {
                        // Sort as numbers
                        return isAsc ? aNum - bNum : bNum - aNum;
                    } else {
                        // Sort as strings
                        if (isAsc) {
                            return aValue.localeCompare(bValue);
                        } else {
                            return bValue.localeCompare(aValue);
                        }
                    }
                });
                
                // Clear the table body
                while (tbody.firstChild) {
                    tbody.removeChild(tbody.firstChild);
                }
                
                // Add sorted rows back to the table
                sortedRows.forEach(row => tbody.appendChild(row));
            });
        });
    </script> -->
</body>

</html>