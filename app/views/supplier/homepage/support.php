<?php
require_once APPROOT . '/views/supplier/navbar/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Support</title>
   
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/support.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
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
                <form class="issue-form" id="report-form" action="<?php echo URLROOT; ?>/StorePageController/submitContactIssue" method="POST">
                    <div class="form-group">
                        <label for="issue-title">Issue Title</label>
                        <input type="text" id="issue-title" name="issue-title" class="form-control" placeholder="Brief description of the issue" required>
                    </div>
                    <div class="form-group">
                        <label for="issue-description">Description</label>
                        <textarea id="issue-description" name="issue-description" class="form-control" rows="4" placeholder="Provide detailed information about your issue" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        Submit Issue
                    </button>
                </form>
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
                    <?php if (!empty($data['faqs'])): ?>
                        <?php foreach ($data['faqs'] as $faq): ?>
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
                    <?php else: ?>
                        <div class="no-faqs">
                            <p>No FAQs available at the moment. Please check back later.</p>
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