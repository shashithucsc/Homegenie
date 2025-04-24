<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/AdminFaq.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Manage FAQ</title>

</head>

<body>
    <?php require_once APPROOT . '/views/Admin/AdminSideBar.php'; ?>
    <section class="main">
        <div class="top">
            <div class="welcome">
                <span class="text">
                    <h3>Manage FAQ</h3>
                </span>
            </div>
            <div class="time" id="clock">
            </div>
        </div>

        <?php if(isset($_SESSION['success_msg'])): ?>
            <div class="success-message" style="background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border-radius: 5px;">
                <?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error_msg'])): ?>
            <div class="error-message" style="background: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border-radius: 5px;">
                <?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
            </div>
        <?php endif; ?>

        <div class="faq-content">
            <div class="topic">
                <span class="text">Add FAQ</span>
            </div>
            <div class="faq-add">
                <form action="<?php echo URLROOT; ?>/AdminController/faq" method="POST">
                    <div class="field title-field">
                        <div class="input-field">
                            <input type="text" id="topic" name="topic" placeholder="Topic" required>
                        </div>
                    </div>
                    <div class="field content-field">
                        <div class="input-field">
                            <textarea id="content" name="content" placeholder="Details" required></textarea>
                        </div>
                    </div>
                    <div class="buttons">
                        <div class="input-field button">
                            <input type="submit" value="Add" />
                        </div>
                        <div class="input-field button">
                            <input type="reset" value="Clear" />
                        </div>
                    </div>
                </form>
            </div>


            <div class="topic">
                <span class="text">Frequently Asked Questions</span>
            </div>
            <div class="faq-list">
                <?php if(!empty($data['faqs'])): ?>
                    <?php foreach($data['faqs'] as $faq): ?>
                        <div class='dash-card'>
                            <div class='field faq-title'>
                                <span class='title'><?php echo htmlspecialchars($faq->topic); ?></span>
                            </div>
                            <div class='field faq-content'>
                                <span class='content'><?php echo htmlspecialchars($faq->content); ?></span>
                            </div>
                            <div class='buttons'>
                                <div class='faq-btn edit'>
                                    <button class='faq edit' onclick='editFAQ(<?php echo $faq->faq_ID; ?>, "<?php echo addslashes($faq->topic); ?>", "<?php echo addslashes($faq->content); ?>")'><i class='bx bx-edit-alt'></i></button>
                                </div>
                                <div class='faq-btn delete'>
                                    <button class='faq delete' onclick='confirmDelete(<?php echo $faq->faq_ID; ?>)'><i class='bx bx-trash'></i></button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No FAQs available yet.</p>
                <?php endif; ?>
            </div>
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()"><i class='bx bx-x'></i></span>
                    <form method="POST" action="<?php echo URLROOT; ?>/AdminController/editFAQ">
                        <h2>Edit FAQ</h2>
                        <input type="hidden" id="edit-id" name="id">
                        <div class="field title-field">
                            <div class="input-field">
                                <input type="text" id="edit-topic" name="topic" placeholder="Topic" required>
                            </div>
                        </div>
                        <div class="field content-field">
                            <div class="input-field">
                                <textarea id="edit-content" name="content" placeholder="Details" required></textarea>
                            </div>
                        </div>
                        <div class="buttons">
                            <div class="faq-btn update">
                                <button type="submit">Update FAQ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="<?php echo URLROOT; ?>/public/js/clock.js"></script>
    <script>
        function editFAQ(id, topic, content) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-topic').value = topic;
            document.getElementById('edit-content').value = content;
            document.getElementById('editModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('editModal').style.display = "none";
        }
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this FAQ?")) {
                window.location.href = "<?php echo URLROOT; ?>/AdminController/deleteFAQ/" + id;
            }
        }
    </script>
</body>

</html>