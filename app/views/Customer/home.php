<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeGenie - Connect with Service Providers & Sellers</title>
    <link rel="stylesheet" href="../../css/style-index.css">
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

    <section class="services-showcase">
        <h2>Popular Services</h2>
        <div class="carousel-container">
            <div class="carousel">
                <div class="carousel-card">
                    <img src="../../resources/plumber.jpg" alt="Plumbing">
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
                    <img src="../../resources/electric.jpg" alt="Plumbing">
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
                    <img src="../../resources/cleaning.jpg" alt="Plumbing">
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
                    <img src="../../resources/painting.jpg" alt="Plumbing">
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
                    <img src="../../resources/gardening.jpg" alt="Plumbing">
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
</body>

</html>