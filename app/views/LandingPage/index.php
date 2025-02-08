<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeGenie - Connect with Service Providers & Sellers</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style-index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <nav class="top-nav">
        <a href="index.php" class="nav-brand">Home<span>Genie</span></a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="services.php">Services</a>
            <a href="../../../supplier/HomeController.php">Store</a>
            <a href="about.php">About</a>
            <button onclick="document.location='../login/login.php'" class="login-btn">Login</button>
        </div>
    </nav>

    <header id="home">
        <div class="hero">
            <h1>Your One-Stop Platform for Home Services</h1>
            <p>Connect with trusted professionals and quality products for all your home needs</p>
            <div class="cta-buttons">
                <button class="primary-btn" onclick = "document.location='services.php'">Find Services</button>
                <button class="secondary-btn" onclick = "document.location='../../../supplier/HomeController.php'">Visit Store</button>
            </div>
        </div>
    </header>

    <section class="user-types">
        <h2>Join As</h2>
        <div class="cards-container">
            <div class="card">
                <i class='bx bx-user' ></i>
                <h3>Customer</h3>
                <p>Find reliable services and products for your home</p>
                <button onclick="document.location='../register/register_cu.php'">Register as Customer</button>
            </div>
            <div class="card">
                <i class='bx bx-wrench'></i>
                <h3>Service Provider</h3>
                <p>Offer your expertise to customers in need</p>
                <button onclick="document.location='../register/register_sp.php'">Register as Provider</button>
            </div>
            <div class="card">
                <i class='bx bx-store' ></i>
                <h3>Seller</h3>
                <p>Sell your products in our marketplace</p>
                <button onclick="document.location='../register/register_su.php'">Register as Seller</button>
            </div>
        </div>
    </section>

    <section class="services-showcase">
        <h2>Popular Services</h2>
        <div class="carousel-container">
            <div class="carousel">
                <div class="carousel-card">
                    <img src="<?php echo URLROOT; ?>/public/img/plumber.jpg" alt="Plumbing">
                    <div class="card-content">
                        <h3>Plumbing Services</h3>
                        <p>Expert plumbing solutions for your home</p>
                        <span class="rating">
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star-half'></i>
                        </span>
                    </div>
                </div>
                <div class="carousel-card">
                    <img src="<?php echo URLROOT; ?>/public/img/electric.jpg" alt="Plumbing">
                    <div class="card-content">
                        <h3>Electrical Work</h3>
                        <p>Professional electrical services</p>
                        <span class="rating">
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star-half'></i>
                        </span>
                    </div>
                </div>
                <div class="carousel-card">
                    <img src="<?php echo URLROOT; ?>/public/img/cleaning.jpg" alt="Plumbing">
                    <div class="card-content">
                        <h3>Home Cleaning</h3>
                        <p>Premium cleaning services</p>
                        <span class="rating">
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star-half'></i>
                        </span>
                    </div>
                </div>
                <div class="carousel-card">
                    <img src="<?php echo URLROOT; ?>/public/img/painting.jpg" alt="Plumbing">
                    <div class="card-content">
                        <h3>Home Painting</h3>
                        <p>Transform your space with color</p>
                        <span class="rating">
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star-half'></i>
                        </span>
                    </div>
                </div>
                <div class="carousel-card">
                    <img src="<?php echo URLROOT; ?>/public/img/gardening.jpg" alt="Plumbing">
                    <div class="card-content">
                        <h3>Gardening</h3>
                        <p>Professional garden maintenance</p>
                        <span class="rating">
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star-half'></i>
                        </span>
                    </div>
                </div>
            </div>
            <button class="carousel-btn prev">❮</button>
            <button class="carousel-btn next">❯</button>
        </div>
    </section>

    <?php require_once APPROOT . '/views/footer.php'; ?>
    <script src="<?php echo URLROOT; ?>/public/js/script-index.js"></script>
</body>
</html>