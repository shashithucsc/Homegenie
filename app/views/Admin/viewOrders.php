
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/style_users.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/AdminManageUsers.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Orders</title>

</head>

<body> 
    <?php require_once APPROOT . '/views/Admin/AdminSideBar.php'; ?>
    
    <section class="main">
        <div class="top">
            <div class="welcome">
                <span class="text">
                    <h3>Orders</h3>
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
                            <th> Order Id </th>
                            <th> Customer ID </th>
                            <th> Supplier ID </th>
                            <th> Products </th>
                            <th> Total </th>
                            <th> Timestamp </th>
                            <th> <i class='bx bx-cog icon'></i> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <php
                        if ($result->rowCount() > 0) {
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["customer_id"] . "</td>";
                                echo "<td>" . $row["supplier_id"] . "</td>";
                                echo "<td>" . $row["products"] . "</td>";
                                echo "<td>" . $row["total"] . "</td>";
                                echo "<td>" . $row["time"] . "</td>";
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