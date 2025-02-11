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
                        <!-- <php
                        if ($result->rowCount() > 0) {
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
                                echo "<td>" . $row["address"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["contact_number"] . "</td>";
                                echo "<td>" . $row["account_type"] . "</td>";
                                echo "<td>";
                                echo "<div class='faq-btn delete'>";
                                echo "<button class='delete' onclick='confirmDelete(" . $row['id'] . ")'><i class='bx bx-user-minus icon'></i></button>";
                                echo "</div>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No data found</td></tr>";
                        }
                        ?> -->
                    </tbody>
                </table>
            </section>
        </div>
    </section>
    <script src="../../js/clock.js"></script>
    <script src="../../js/script-users.js"></script>
</body>

</html>