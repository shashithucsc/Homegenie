<?php
require_once APPROOT . '/views/inc/components/logginNavbar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo URLROOT ?>/public/css/register.css" rel="stylesheet">
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

    <div class="main-container">
        <h1>Register As Customer</h1>
        <form class="register-form" action="<?php echo URLROOT . '/SignUpController/registerUser'; ?>" method="POST"
            enctype="multipart/form-data">

            <!-- Personal Information -->
            <fieldset>
                <legend>Personal Information</legend>
                <div class="flex-row">
                    <input type="hidden" name="role" id="role" value="customer">
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
                        <label for="province">Province</label>
                        <select id="province" name="province" required>
                            <option value="">-- Select Province --</option>
                            <option value="Western">Western</option>
                            <option value="Central">Central</option>
                            <option value="Southern">Southern</option>
                            <option value="Uva">Uva</option>
                            <option value="Sabaragamuwa">Sabaragamuwa</option>
                            <option value="North Western">North Western</option>
                            <option value="North Central">North Central</option>
                            <option value="Northern">Northern</option>
                            <option value="Eastern">Eastern</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="district">District</label>
                        <select id="district" name="district" required>
                            <option value="">-- Select District --</option>
                            <option value="Ampara">Ampara</option>
                            <option value="Anuradhapura">Anuradhapura</option>
                            <option value="Badulla">Badulla</option>
                            <option value="Batticaloa">Batticaloa</option>
                            <option value="Colombo">Colombo</option>
                            <option value="Galle">Galle</option>
                            <option value="Gampaha">Gampaha</option>
                            <option value="Hambantota">Hambantota</option>
                            <option value="Jaffna">Jaffna</option>
                            <option value="Kalutara">Kalutara</option>
                            <option value="Kandy">Kandy</option>
                            <option value="Kegalle">Kegalle</option>
                            <option value="Kilinochchi">Kilinochchi</option>
                            <option value="Kurunegala">Kurunegala</option>
                            <option value="Mannar">Mannar</option>
                            <option value="Matale">Matale</option>
                            <option value="Matara">Matara</option>
                            <option value="Monaragala">Monaragala</option>
                            <option value="Mullaitivu">Mullaitivu</option>
                            <option value="Nuwara Eliya">Nuwara Eliya</option>
                            <option value="Polonnaruwa">Polonnaruwa</option>
                            <option value="Puttalam">Puttalam</option>
                            <option value="Ratnapura">Ratnapura</option>
                            <option value="Trincomalee">Trincomalee</option>
                            <option value="Vavuniya">Vavuniya</option>
                            <!-- Add more districts -->
                        </select>
                    </div>
                </div>

                <div class="flex-row">
                    <div class="input-group">
                        <label for="street">Street</label>
                        <input type="text" id="street" name="street" required>
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
</body>

</html>