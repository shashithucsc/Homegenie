<!--  -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo URLROOT; ?>/css/AdminDashBoard.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Admin Dashboard</title>
</head>

<body>
    <?php require_once APPROOT . '/views/Admin/AdminSideBar.php'; ?>
    <section class="main">
        <div class="top">
            <div class="welcome">
                <span class="text">Welcome, </span>
                <!-- <span class="name">Admin</span> -->
                <?php
                echo "<span class='name'>{$data['adminName']}</span>";
                ?>
            </div>
            <div class="time" id="clock">
            </div>
        </div>

        <div class="dash-content">
            <div class="dash-card">
                <div class="field title">
                    Users
                </div>
                <div class="field">
                    <span class="count"><?php echo $data['userCounts']['customers']; ?></span>
                    <span class="description">Customers</span>
                </div>
                <div class="field">
                    <span class="count"><?php echo $data['userCounts']['serviceProviders']; ?></span>
                    <span class="description">Service Providers</span>
                </div>
                <div class="field">
                    <span class="count"><?php echo $data['userCounts']['suppliers']; ?></span>
                    <span class="description">Suppliers</span>
                </div>
            </div>

            <div class="dash-card">
                <div class="field title">
                    Pending Verification
                </div>
                <div class="field">
                    <span class="count"><?php echo $data['pendingVerifications']['serviceProviders']; ?></span>
                    <span class="description">Service Providers</span>
                </div>
                <!-- <div class="field">
                    <span class="count"><?php echo $data['pendingVerifications']['suppliers']; ?></span>
                    <span class="description">Suppliers</span>
                </div> -->
            </div>

            <div class="dash-card">
                <div class="field title">
                    Issues
                </div>
                <div class="field">
                    <span class="count"><?php echo $data['pendingIssues']; ?></span>
                    <span class="description">Pending Verification</span>
                </div>
            </div>

            <div class="dash-card">
                <div class="field title">
                    Orders
                </div>
                <div class="field">
                    <span class="count"><?php echo $data['orderCounts']['pastWeek']; ?></span>
                    <span class="description">Past Week</span>
                </div>
                <div class="field">
                    <span class="count"><?php echo $data['orderCounts']['all']; ?></span>
                    <span class="description">All</span>
                </div>
            </div>
        </div>
        <div class="dash-card chart-card">
            <div class="field title">
                User Growth
            </div>
            <canvas id="userGrowthChart"></canvas>
        </div>

        <div class="dash-card chart-card">
            <div class="field title">
                Revenue Chart
            </div>
            <canvas id="revenueChart"></canvas>
        </div>
    </section>
    <script src="<?php echo URLROOT; ?>/public/js/clock.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Convert PHP arrays to JSON for JavaScript use
        const userGrowthData = <?php echo json_encode($data['userGrowthData']); ?>;
        const revenueData = <?php echo json_encode($data['revenueData']); ?>;
        
        const ctx1 = document.getElementById('userGrowthChart').getContext('2d');
        const userGrowthChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'User Growth',
                    data: userGrowthData,
                    
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Revenue',
                    data: revenueData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>