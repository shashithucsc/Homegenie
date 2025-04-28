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
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/password-toggle.css">
    <style>
        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
    <title>Register as Service Provider</title>
</head>

<body>
    <?php require_once APPROOT . '/views/inc/components/logginNavbar.php'; ?>

    <div class="main-container">
        <h1>Register As Service Provider</h1>
        <form class="register-form" action="<?php echo URLROOT . '/SignUpController/registerUser'; ?>" method="POST"
            enctype="multipart/form-data">

            <input type="hidden" name="role" id="role" value="service_provider">
            <fieldset>
                <legend>Personal Information</legend>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first_name" required placeholder="Sandun">
                    </div>
                    <div class="input-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last_name" required placeholder="Sahiru">
                    </div>
                </div>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="contact-number">Contact Number</label>
                        <input type="tel" id="contact-number" name="contact_number" pattern="07[0-9]{8}" placeholder="07XXXXXXXX" title="Invalid Phone Number Format" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required placeholder="sahiru@gmail.com">
                    </div>
                </div>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="street">Street</label>
                        <input type="text" id="street" name="street" required placeholder="No. 123, Main Street">
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
                        </select>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="profile-image">Profile Image</label>
                        <input type="file" id="profile-image" name="profile_image" accept="image/*" required>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Professional Information</legend>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="expertise">Expertise/Category of Service</label>
                        <select id="expertise" name="expertise" required>
                            <option value="plumbing">Plumbing</option>
                            <option value="electrical">Electrical Work</option>
                            <option value="cleaning">Cleaning</option>
                            <option value="painting">Painting</option>
                            <option value="gardening">Gardening</option>
                            <option value="masonry">Masonry</option>
                        </select>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="description">Description of Services</label>
                        <textarea id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Availability Details</legend>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="working-hours">Working Hours</label>
                        <input type="text" id="working-hours" name="working_hours" required
                            placeholder="9:00 AM - 5:00 PM">
                    </div>
                    <div class="input-group">
                        <label for="service-areas">Preferred Service Areas</label>
                        <input type="text" id="service-areas" name="service_areas" required
                            placeholder="Colombo, Gampaha, etc.">
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Verification Details</legend>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="id-number">National ID Number</label>
                        <input type="text" id="id-number" name="id_number" required 
                               pattern="^(?:[0-9]{9}[vVxX]|[0-9]{12})$"
                               title="Enter a validNIC number. For old format: 9 digits followed by V or X (e.g., 000000000V). For new format: 12 digits (e.g., 197412345678)."
                               placeholder="Enter NIC number">
                    </div>
                </div>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="id-front">Upload ID Front Photo</label>
                        <input type="file" id="id-front" name="id_front" accept="image/*" required>
                    </div>
                    <div class="input-group">
                        <label for="id-back">Upload ID Back Photo</label>
                        <input type="file" id="id-back" name="id_back" accept="image/*" required>
                    </div>
                </div>
            </fieldset>

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

            <fieldset>
                <legend>Banking and Payment Information</legend>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="bank-details">Bank Account Details</label>
                        <input type="text" id="bank-details" name="bank_details" required>
                    </div>
                </div>
            </fieldset>

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
    <script src="<?php echo URLROOT ?>/public/js/register.js"></script>
    <script src="<?php echo URLROOT; ?>/public/js/password-toggle.js"></script>
</body>

</html>