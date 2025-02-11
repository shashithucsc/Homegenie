<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

include '../db.php';

$query = "SELECT * FROM users WHERE id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit;
}
$customerName = $user["first_name"] . " " . $user["last_name"]; // Get the admin's name

$profileImage = $user['profile_image'];

$profileImagePath = "../register/uploads/" . $profileImage;
if (!file_exists($profileImagePath)) {
    echo "Profile image not found: " . htmlspecialchars($profileImagePath);
    exit;
}
// Fetch all FAQs
$sql = "SELECT faq_ID, topic, content FROM faq ";
$stmt = $conn->query($sql);
$num_rows = $stmt->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - HomeGenie</title>
    <link rel="stylesheet" href="faq.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<nav>
        <a href="cu_home.php" class="nav-brand">Home<span>Genie</span></a>
        <div class="nav-links">
            <a href="cu_home.php">Home</a>
            <a href="services.php">Services</a>
            <a href="../../../supplier/HomeController.php">Store</a>
            <a href="cu_about.php">About</a>
            <div class="profile-container">
                <span class="name"><?php echo htmlspecialchars($customerName); ?></span>
                <img src="<?php echo htmlspecialchars($profileImagePath); ?>" alt="Profile Picture"
                    class="profile-image">
                <div class="profile-dropdown">
                    <a href="cu_profile.php"><i class='bx bx-user'></i> My Profile</a>
                    <!-- <a href="cu_appointments.php"><i class='bx bx-paperclip'></i> My Appointments</a> -->
                    <!-- <a href="cu_settings.php"><i class='bx bx-cog'></i> Settings</a> -->
                    <a href="../login/logout.php"><i class='bx bx-log-out'></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <header>
        <h1>Frequently Asked Questions</h1>
    </header>

    <section class="faq-section">
        <div class="faq-container">
            <?php
            if ($num_rows > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='faq-item'>";
                    echo "<h3 class='faq-question'>" . htmlspecialchars($row['topic']) . "</h3>";
                    echo "<p class='faq-answer'>" . htmlspecialchars($row['content']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No FAQs available yet.</p>";
            }
            ?>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-section brand">
                <h3>Home<span>Genie</span></h3>
                <p>Connecting homes with quality services and products</p>
                <div class="social-links">
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                    <a href="#"><i class='bx bxl-linkedin'></i></a>
                    <a href="#"><i class='bx bxl-github'></i></a>
                </div>
            </div>
            <div class="footer-section links">
                <h3>Quick Links</h3>
                <div class="two-column-links">
                    <div>
                        <a href="cu_home.php">Home</a>
                        <a href="services.php">Services</a>
                        <a href="../../../supplier/HomeController.php">Store</a>
                        <a href="cu_about.php">About</a>
                    </div>
                    <div>
                        <a href="#privacy">Privacy Policy</a>
                        <a href="#terms">Terms of Service</a>
                        <a href="cu_faq.php">FAQ</a>
                        <a href="cu_contact.php">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="footer-section contact">
                <h3>Contact Us</h3>
                <div class="contact-info">
                    <p><i class='bx bx-phone'></i> (+94) 700000000</p>
                    <p><i class="bx bx-envelope"></i> info@homegenie.com</p>
                    <p><i class="bx bx-map"></i> No.123, Colombo Road, Galle.</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 HomeGenie. All rights reserved.</p>
        </div>
    </footer>
    <script src="faq.js"></script>
</body>
</html>