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
                    <input type="search" placeholder="Search ...">
                    <i class='bx bx-search'></i>
                </div>
            </section>
            <section class="table-body">
                <table>
                    <thead>
                        <tr>
                            <th> Id </th>
                            <th> Name </th>
                            <th> Address </th>
                            <th> Email </th>
                            <th> Contact No </th>
                            <th> Account Type </th>
                            <th> <i class='bx bx-cog icon'></i> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($data['users']) && count($data['users']) > 0) : ?>
                            <?php foreach($data['users'] as $user) : ?>
                                <tr>
                                    <td><?php echo $user->user_id; ?></td>
                                    <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                    <td><?php echo $user->address; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo $user->contact_number; ?></td>
                                    <td><?php echo ucfirst($user->role); ?></td>
                                    <!-- Inside the table row for each user -->
                                    <td>
                                        <div class='faq-btn delete'>
                                            <form action="<?php echo URLROOT; ?>/admin/deleteUser" method="POST">
                                                <input type="hidden" name="user_id" value="<?= $user->user_id; ?>">
                                                <button type="submit" class='delete' onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <i class='bx bx-user-minus icon'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan='7'>No data found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </section>
    <script src="<?php echo URLROOT; ?>/public/js/clock.js"></script>
    <script src="<?php echo URLROOT; ?>/public/js/script-users.js"></script>
</body>

</html>