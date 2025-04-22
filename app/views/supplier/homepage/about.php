<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierAbout.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">
</head>
<?php require_once APPROOT . '/views/supplier/navbar/navbar.php'; ?>

<body>
    <div class ="main1">
        <section class="hero">
            <div class="hero-content">
                <h1>Connecting Homes with Quality Services</h1>
                <p>Building trust between homeowners and service providers since 2024</p>
            </div>
        </section>

        <section class="story">
            <div class="container1">
                <div class="story-content">
                    <div class="story-text">
                        <h2>Our Story</h2>
                        <p>Founded in 2024 as a university project, HomeGenie was born from a pressing issue faced by
                            countless Sri Lankans: finding reliable professionals for home services was often a
                            challenge. Most homeowners had to rely on word-of-mouth recommendations, leading to delays
                            and uncertainty.</p>
                        <p>Our team of four passionate undergraduates from the University of Colombo School of Computing
                            recognized this gap and envisioned a digital solution. Thus, HomeGenie was created—a
                            comprehensive platform designed to connect homeowners with skilled professionals across
                            various trades.</p>
                    </div>
                    <div class="story-image">
                        <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=800&auto=format"
                            alt="Team collaboration">
                    </div>
                </div>
            </div>
        </section>

        <section class="values">
            <div class="container1">
                <h2>Our Core Values</h2>
                <div class="values-grid">
                    <div class="value-card">
                        <i class='bx bx-shield-quarter'></i>
                        <h3>Trust & Safety</h3>
                        <p>We thoroughly verify all service providers and sellers to ensure your safety and peace of
                            mind.</p>
                    </div>
                    <div class="value-card">
                        <i class='bx bxs-star'></i>
                        <h3>Quality Service</h3>
                        <p>We maintain high standards through our rigorous vetting process and continuous monitoring.
                        </p>
                    </div>
                    <div class="value-card">
                        <i class='bx bx-badge-check'></i>
                        <h3>Reliability</h3>
                        <p>We ensure timely service delivery and maintain transparent communication throughout.</p>
                    </div>
                    <div class="value-card">
                        <i class='bx bxs-user'></i>
                        <h3>Community First</h3>
                        <p>We build strong relationships between service providers and customers, fostering a trusted
                            community.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="team">
            <div class="container1">
                <h2>Our Team</h2>
                <div class="team-grid">
                    <div class="team-member">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&auto=format"
                            alt="SK">
                        <h3>Shakila Thathsara</h3>
                        <p class="role">Admin</p>
                        <p class="bio">UCSC Undergraduate</p>
                    </div>
                    <div class="team-member">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&auto=format"
                            alt="KB">
                        <h3>Kavindi Basnayaka</h3>
                        <p class="role">Customer</p>
                        <p class="bio">UCSC Undergraduate</p>
                    </div>
                    <div class="team-member">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&auto=format"
                            alt="MM">
                        <h3>Mandinu Maneth</h3>
                        <p class="role">Service Provider</p>
                        <p class="bio">UCSC Undergraduate</p>
                    </div>
                    <div class="team-member">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&auto=format"
                            alt="SR">
                        <h3>Shashith Rashmika</h3>
                        <p class="role">Supplier</p>
                        <p class="bio">UCSC Undergraduate</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta">
            <div class="container1">
                <h2>Join Our Growing Community</h2>
                <p>Whether you're a homeowner, service provider, or seller, we'd love to have you as part of our
                    community.</p>
                <div class="cta-buttons">
                    <!-- <a href="#" class="primary-btn">Get Started</a> -->
                    <a href="contact.php" class="secondary-btn">Contact Us</a>
                </div>
            </div>
        </section>
        <?php require_once APPROOT . '/views/footer.php'; ?>
    </div>
</body>

</html>