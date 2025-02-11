<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/AdminDashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/AdminViewIssues.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Manage Issues</title>

</head>

<body>
    <?php require_once APPROOT . '/views/Admin/AdminSideBar.php'; ?>
    <section class="main">
        <div class="top">
            <div class="welcome">
                <span class="text">Welcome, </span>
                <span class="name">Admin</span>
            </div>
            <div class="time">
            </div>
        </div>

        <div class="dash-content">
            <div class="issues-container">
                <h2>Reported Issues</h2>
                <div class="issue">
                    <div class="issue-header">
                        <span class="issue-title">Issue Title 1</span>
                        <span class="issue-date">2023-10-01</span>
                    </div>
                    <div class="issue-body">
                        <p>Description of the issue goes here... Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati voluptatibus quibusdam sapiente magni, libero animi perferendis. Quisquam, fugit reiciendis earum facilis ullam neque unde, in fuga deserunt illum culpa praesentium.</p>
                    </div>
                    <div class="issue-reply">
                        <textarea placeholder="Reply to this issue..."></textarea>
                        <button class="reply-button">Send Reply</button>
                    </div>
                </div>
                <div class="issue">
                    <div class="issue-header">
                        <span class="issue-title">Issue Title 1</span>
                        <span class="issue-date">2023-10-01</span>
                    </div>
                    <div class="issue-body">
                        <p>Description of the issue goes here... Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati voluptatibus quibusdam sapiente magni, libero animi perferendis. Quisquam, fugit reiciendis earum facilis ullam neque unde, in fuga deserunt illum culpa praesentium.</p>
                    </div>
                    <div class="issue-reply">
                        <textarea placeholder="Reply to this issue..."></textarea>
                        <button class="reply-button">Send Reply</button>
                    </div>
                </div>
                <div class="issue">
                    <div class="issue-header">
                        <span class="issue-title">Issue Title 1</span>
                        <span class="issue-date">2023-10-01</span>
                    </div>
                    <div class="issue-body">
                        <p>Description of the issue goes here... Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati voluptatibus quibusdam sapiente magni, libero animi perferendis. Quisquam, fugit reiciendis earum facilis ullam neque unde, in fuga deserunt illum culpa praesentium.</p>
                    </div>
                    <div class="issue-reply">
                        <textarea placeholder="Reply to this issue..."></textarea>
                        <button class="reply-button">Send Reply</button>
                    </div>
                </div>
                <div class="issue">
                    <div class="issue-header">
                        <span class="issue-title">Issue Title 1</span>
                        <span class="issue-date">2023-10-01</span>
                    </div>
                    <div class="issue-body">
                        <p>Description of the issue goes here... Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati voluptatibus quibusdam sapiente magni, libero animi perferendis. Quisquam, fugit reiciendis earum facilis ullam neque unde, in fuga deserunt illum culpa praesentium.</p>
                    </div>
                    <div class="issue-reply">
                        <textarea placeholder="Reply to this issue..."></textarea>
                        <button class="reply-button">Send Reply</button>
                    </div>
                </div>
                <!-- Repeat similar blocks for other issues -->
            </div>
        </div>
    </section>
</body>

</html>