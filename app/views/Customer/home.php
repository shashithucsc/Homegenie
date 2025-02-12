<?php
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeGenie - Connect with Service Providers & Sellers</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style-index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php require_once APPROOT . '/views/Customer/loggedNavBar.php'; ?>

    <header id="home">
        <div class="hero">
            <h1>Your One-Stop Platform for Home Services</h1>
            <p>Connect with trusted professionals and quality products for all your home needs</p>
            <div class="cta-buttons">
                <button class="primary-btn" onclick="document.location='services.php'">Find Services</button>
                <button class="secondary-btn" onclick="document.location='../../../supplier/HomeController.php'">Visit
                    Store</button>
            </div>
        </div>
    </header>

    <?php require_once APPROOT . '/views/LandingPage/servicesShowcase.php'; ?>

    <?php require_once APPROOT . '/views/Customer/footer.php'; ?>

    <script src="<?php echo URLROOT; ?>/public/js/script-index.js"></script>
</body>

</html>