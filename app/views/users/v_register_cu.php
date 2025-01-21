<?php
require_once APPROOT . '/views/inc/components/logginNavbar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo URLROOT?>/public/css/register.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Register as Customer</title>
    <style>
        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>

<body>
    <nav class="top-nav">
        <a href="../index/index.php" class="nav-brand">Home<span>Genie</span></a>
        <div class="nav-links">
            <a href="../index/about.php">About</a>
            <button onclick="document.location='../login/login.php'" class="login-btn">Login</button>
        </div>
    </nav>
    <!-- <section> -->
    <div class="main-container">
        <!-- <div class="logo">Home<span>Genie</span></div> -->
        <h1>Register As Customer</h1>
        <form class="register-form" action="" method="POST"
            enctype="multipart/form-data">
            <!-- Personal Information -->
            <fieldset>
                <legend>Personal Information</legend>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first_name" required>
                    </div>
                    <div class="input-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last_name" required>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="contact-number">Contact Number</label>
                        <input type="tel" id="contact-number" name="contact_number" pattern="[0-9]{10}"
                            placeholder="07XXXXXXXX" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="address">Home Address</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                </div>
            </fieldset>

            <!-- Login Credentials -->
            <fieldset>
                <legend>Login Credentials</legend>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="password">Password</label>
                        <div class="password-container">
                            <input type="password" id="password" name="password" required>
                            <i class="bx bx-hide show-hide"></i>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="confirm-password">Confirm Password</label>
                        <div class="password-container">
                            <input type="password" id="confirm-password" name="confirm_password" required>
                            <i class="bx bx-hide show-hide"></i>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- Terms and Conditions -->
            <fieldset>
                <legend>Terms and Conditions</legend>
                <div class="flex-row">
                    <div class="input-group">
                        <label>
                            <input type="checkbox" name="agree_terms" required> I agree to the system rules, terms, and
                            conditions.
                        </label>
                    </div>
                </div>
            </fieldset>

            <button type="submit" class="register-btn">Register</button>
        </form>
    </div>
    <!-- </section> -->
    <script>
        document.querySelector('.register-form').addEventListener('submit', function (event) {
            const contactNumber = document.getElementById('contact-number').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            // Validate contact number
            if (!/^07[0-9]{8}$/.test(contactNumber)) {
                alert("Invalid contact number.");
                event.preventDefault();
                return;
            }

            // Validate email
            if (!/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
                alert("Invalid email format.");
                event.preventDefault();
                return;
            }

            // Validate password match
            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                event.preventDefault();
                return;
            }
        });
    </script>
    <script src="register.js"></script>
</body>

</html>