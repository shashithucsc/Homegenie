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
    <style>
        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
    <title>Register as Supplier</title>
</head>

<body>
    <div class="main-container">
        <!-- <div class="logo">Home<span>Genie</span></div> -->
        <h1>Register As a Supplier</h1>
        <form class="register-form" action="<?php echo URLROOT . '/SignUpController/registerUser'; ?>" method="POST"
            enctype="multipart/form-data">
            <input type="hidden" name="role" id="role" value="supplier">

            <!-- Personal Information -->
            <fieldset>
                <legend>Personal Information</legend>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first_name" required placeholder="John">
                    </div>
                    <div class="input-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last_name" required placeholder="Doe">
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
                        <input type="email" id="email" name="email" required placeholder="john.doe@example.com">
                    </div>
                </div>

                <div class="flex-row">
                    <div class="input-group">
                        <label for="expertise">Expertise</label>
                        <input type="text" id="expertise" name="expertise" required
                            placeholder="Plumbing, Electrical, etc.">
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
                            <!-- Add more districts -->
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

            <!-- Verification Details -->
            <fieldset>
                <legend>Verification Details</legend>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="id-number">National ID Number</label>
                        <input type="text" id="id-number" name="id_number" required>
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

            <!-- Banking and Payment Information -->
            <fieldset>
                <legend>Banking and Payment Information</legend>
                <div class="flex-row">
                    <div class="input-group">
                        <label for="bank-details">Bank Account Details</label>
                        <input type="text" id="bank-details" name="bank_details" required>
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
    <script src="<?php echo URLROOT ?>/public/js/register.js"></script>
</body>

</html>