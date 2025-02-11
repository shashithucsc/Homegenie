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
        <div class="faq-content">
            <div class="topic">
                <span class="text">Add FAQ</span>
            </div>
            <div class="faq-add">
                <form action="faq.php" method="POST">
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
                <!-- <php
                if ($num_rows > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='dash-card'>";
                        echo "<div class='field faq-title'>";
                        echo "<span class='title'>" . $row['topic'] . "</span>";
                        echo "</div>";
                        echo "<div class='field faq-content'>";
                        echo "<span class='content'>" . $row['content'] . "</span>";
                        echo "</div>";
                        echo "<div class='buttons'>";
                        echo "<div class='faq-btn edit'>";
                        echo "<button class='faq edit' onclick='editFAQ(" . $row['faq_ID'] . ", \"" . addslashes($row['topic']) . "\", \"" . addslashes($row['content']) . "\")'><i class='bx bx-edit-alt' ></i></button>";
                        echo "</div>";
                        echo "<div class='faq-btn delete'>";
                        echo "<button class='faq delete' onclick='confirmDelete(" . $row['faq_ID'] . ")'><i class='bx bx-trash'></i></button>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No FAQs available yet.</p>";
                }
                ?> -->
            </div>
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()"><i class='bx bx-x'></i></span>
                    <form method="POST" action="faq_edit.php">
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
    <script src="../../js/clock.js"></script>
    <script src="../../js/script_faq.js"></script>
</body>

</html>