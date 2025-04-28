<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HomeGenie</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/loggin.css" type="text/css">
</head>

<body>
    <?php require_once APPROOT . '/views/inc/components/logginNavbar.php'; ?>
    <div class="container">
        <div class="left-panel">
            <img src="<?php echo URLROOT; ?>/public/img/backgroundLogin.png" alt="HomeGenie" class="back-image">
        </div>

        <div class="right-panel">
            <h2 class="title">Login</h2>
            <form action="<?php echo URLROOT; ?>/LoginController/login" method="POST">

                <div class="input-field <?php echo isset($data['email_err']) && !empty($data['email_err']) ? 'error' : ''; ?>">
                    <input type="text" name="email" placeholder="Email"
                        value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>" required>
                    <?php if(isset($data['email_err']) && !empty($data['email_err'])): ?>
                        <span class="error-message"><?php echo $data['email_err']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="input-field <?php echo isset($data['password_err']) && !empty($data['password_err']) ? 'error' : ''; ?>">
                    <input type="password" name="password" placeholder="Password"
                        value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>" required>
                    <?php if(isset($data['password_err']) && !empty($data['password_err'])): ?>
                        <span class="error-message"><?php echo $data['password_err']; ?></span>
                    <?php endif; ?>
                </div>
                <input type="submit" class="login-btn" value="Login">

            </form>

            <div class="register-link">
                <p>Don't have an account? <button class="signup-btn">Sign Up</button></p>
            </div>

        </div>
    </div>

    <div class="modal" id="signupModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Sign Up</h2>
            <div class="signup-options">

                <button data-type="customer"
                    onclick="document.location='<?php echo URLROOT; ?>/SignUpController/customer'">Customer</button>
                <button data-type="provider"
                    onclick="document.location='<?php echo URLROOT; ?>/SignUpController/provider'">ServiceProvider</button>
                <button data-type="seller"
                    onclick="document.location='<?php echo URLROOT; ?>/SignUpController/supplier'">Seller</button>
            </div>
        </div>
    </div>

    <script>

        const modal = document.getElementById('signupModal');
        const signUpBtn = document.querySelector('.signup-btn');
        const closeModal = document.querySelector('.close-modal');
        const signupOptions = document.querySelectorAll('.signup-options button');

        signUpBtn.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>

    <?php if (isset($data['message'])): ?>
    <script>
        alert("<?php echo $data['message']; ?>");
        <?php if (isset($data['redirectUrl'])): ?>
            window.location.href = "<?php echo $data['redirectUrl']; ?>";
        <?php endif; ?>
    </script>
    <?php endif; ?>
</body>

</html>