<?php
require_once APPROOT . '/views/ServiceProvider/navbar_svp.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Support</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SVP/SVP_support.css">
</head>

<body>
    <div class="container">
        <main class="card">
            <div class="card-header">
                <h2>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                        </path>
                    </svg>
                    Report an Issue
                </h2>
            </div>
            <div class="card-body">
                <?php flash('issue_message'); ?>
                <form class="issue-form" action="<?php echo URLROOT; ?>/ServiceProviderController/createIssue" method="POST">
                    <div class="form-group">
                        <label for="issue-description">Describe your issue</label>
                        <textarea id="issue-description" name="description" class="form-control <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>" rows="4"
                            placeholder="Please provide detailed information about your issue" required><?php echo isset($data['description']) ? $data['description'] : ''; ?></textarea>
                        <span class="invalid-feedback"><?php echo isset($data['description_err']) ? $data['description_err'] : ''; ?></span>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        Submit Issue
                    </button>
                </form>

                <div class="issue-list">
                    <?php if (!empty($data['issues'])) : ?>
                        <?php foreach ($data['issues'] as $issue) : ?>
                            <div class="issue-item">
                                <div class="issue-header">
                                    <span class="issue-title"><?php echo htmlspecialchars($issue->description); ?></span>
                                    <span class="status-badge <?php echo $issue->status == 'completed' ? 'status-resolved' : 'status-pending'; ?>">
                                        <?php echo $issue->status == 'completed' ? 'Solved' : (!empty($issue->status) ? ucfirst($issue->status) : 'Pending'); ?>
                                    </span>
                                </div>
                                
                                <div class="issue-date">
                                    <?php echo date('F d, Y', strtotime($issue->created_at)); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="no-issues">
                            <p>No issues reported yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <aside class="card">
            <div class="card-header">
                <h2>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    Frequently Asked Questions
                </h2>
            </div>
            <div class="card-body">
                <div class="faq-list">
                    <?php if (!empty($data['faqs'])) : ?>
                        <?php foreach ($data['faqs'] as $faq) : ?>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <?php echo htmlspecialchars($faq->topic); ?>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>
                                <div class="faq-answer">
                                    <?php echo htmlspecialchars($faq->content); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="no-faqs">
                            <p>No FAQs available at the moment.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
    </div>

    <script>
        // Handle FAQ toggles
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const isActive = answer.classList.contains('active');

                // Close all other answers
                document.querySelectorAll('.faq-answer').forEach(a => {
                    a.classList.remove('active');
                });

                // Toggle current answer
                if (!isActive) {
                    answer.classList.add('active');
                }

                // Rotate arrow icon
                const arrow = question.querySelector('svg');
                document.querySelectorAll('.faq-question svg').forEach(svg => {
                    svg.style.transform = 'rotate(0deg)';
                });

                if (!isActive) {
                    arrow.style.transform = 'rotate(180deg)';
                }
            });
        });
    </script>
</body>

</html>

<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>