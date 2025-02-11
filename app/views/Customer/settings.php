<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}


require_once '../db.php';

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - HomeGenie</title>
    <link rel="stylesheet" href="../../css/style-index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .container {
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
            background: var(--white);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-header h1 {
            font-size: 2rem;
            color: var(--primary-color);
        }

        .profile-details {
            margin-top: 20px;
        }

        fieldset {
            border: 1px solid var(--primary-color);
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }

        legend {
            padding: 0 10px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .flex-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .input-group {
            flex: 1;
            min-width: 200px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: var(--text-color);
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--primary-color);
            border-radius: 5px;
            transition: var(--transition);
        }

        .input-group input:focus {
            border-color: var(--secondary-color);
            outline: none;
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            width: calc(100% - 30px);
            padding-right: 30px;
        }

        .password-container .show-hide {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--primary-color);
        }

        .register-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
        }

        .register-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
    </style>
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

    <div class="container">
        <div class="profile-header">
            <h1>Settings</h1>
        </div>
        <div class="profile-details">
            <form action="cu_update_settings.php" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Update Profile</legend>
                    <div class="flex-row">
                        <div class="input-group">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first_name"
                                value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                        </div>
                        <div class="input-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last_name"
                                value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                        </div>
                    </div>
                    <div class="flex-row">
                        <div class="input-group">
                            <label for="contact-number">Contact Number</label>
                            <input type="tel" id="contact-number" name="contact_number" pattern="[0-9]{10}"
                                value="<?php echo htmlspecialchars($user['contact_number']); ?>" required>
                        </div>
                        <div class="input-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email"
                                value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                    </div>
                    <div class="flex-row">
                        <div class="input-group">
                            <label for="address">Home Address</label>
                            <input type="text" id="address" name="address"
                                value="<?php echo htmlspecialchars($user['address']); ?>" required>
                        </div>
                    </div>
                    <div class="flex-row">
                        <div class="input-group">
                            <label for="profile-image">Profile Image</label>
                            <input type="file" id="profile-image" name="profile_image" accept="image/*">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Change Password</legend>
                    <div class="flex-row">
                        <div class="input-group">
                            <label for="new-password">New Password</label>
                            <div class="password-container">
                                <input type="password" id="new-password" name="new_password">
                                <i class="bx bx-hide show-hide"></i>
                            </div>
                        </div>
                        <div class="input-group">
                            <label for="confirm-new-password">Confirm New Password</label>
                            <div class="password-container">
                                <input type="password" id="confirm-new-password" name="confirm_new_password">
                                <i class="bx bx-hide show-hide"></i>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <button type="submit" class="register-btn">Update Settings</button>
            </form>
        </div>
    </div>

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

    <script src="../../js/script-index.js"></script>
    <script>
        // Show/Hide Password Functionality
        const eyeIcons = document.querySelectorAll(".show-hide");
        eyeIcons.forEach((icon) => {
            icon.addEventListener("click", () => {
                const passwordInput = icon.previousElementSibling;
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    icon.classList.replace("bx-hide", "bx-show");
                } else {
                    passwordInput.type = "password";
                    icon.classList.replace("bx-show", "bx-hide");
                }
            });
        });
    </script>
</body>

</html>