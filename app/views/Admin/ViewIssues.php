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
                <span class="text">
                    <h3>Reported Issues</h3>
                </span>
            </div>
            <div class="time">
            </div>
        </div>

        <div class="dash-content" style="display: block;">
            <div class="issues-container">
                <h2>Pending Issues</h2>
                
                <?php 
                $pendingIssues = array_filter($data['issues'], function($issue) {
                    return $issue->status == 'pending';
                });
                
                if(empty($pendingIssues)) : ?>
                    <p>No pending issues found.</p>
                <?php else : ?>
                    <?php foreach($pendingIssues as $issue) : ?>
                        <div class="issue">
                            <div class="issue-header">
                                <span class="issue-title"><?php echo $issue->first_name . ' ' . $issue->last_name . ' | ' . $issue->email; ?></span>
                                <span class="issue-date"><?php echo isset($issue->created_at) ? date('Y-m-d', strtotime($issue->created_at)) : 'N/A'; ?></span>
                            </div>
                            <div class="issue-body">
                                <p><?php echo $issue->description; ?></p>
                            </div>
                            <div class="issue-reply">
                                <form action="<?php echo URLROOT; ?>/AdminController/markIssueComplete" method="POST">
                                    <input type="hidden" name="issue_id" value="<?php echo $issue->id; ?>">
                                    <button type="submit" class="reply-button">Mark as Complete</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Completed Issues Section -->
            <div class="issues-container completed-issues">
                <h2>Completed Issues</h2>
                
                <?php 
                $completedIssues = array_filter($data['issues'], function($issue) {
                    return $issue->status == 'completed';
                });
                
                if(empty($completedIssues)) : ?>
                    <p>No completed issues found.</p>
                <?php else : ?>
                    <?php foreach($completedIssues as $issue) : ?>
                        <div class="issue completed">
                            <div class="issue-header">
                                <span class="issue-title"><?php echo $issue->first_name . ' ' . $issue->last_name . ' | ' . $issue->email; ?></span>
                                <span class="issue-date"><?php echo isset($issue->created_at) ? date('Y-m-d', strtotime($issue->created_at)) : 'N/A'; ?></span>
                            </div>
                            <div class="issue-body">
                                <p><?php echo $issue->description; ?></p>
                            </div>
                            <div class="issue-reply">
                                <span class="completed-label">Completed</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>

</html>