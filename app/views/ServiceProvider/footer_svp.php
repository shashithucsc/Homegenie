<head>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>

:root {
    --primary-color: #2563eb;
    --secondary-color: #1e40af;
    --accent-color: #3b82f6;
    --text-color: #1f2937;
    --light-bg: #f3f4f6;
    --white: #ffffff;
    --transition: all 0.3s ease;
    --footer-bg: #1a1f2b;
    --footer-text: #e5e7eb;
}


  footer {
    background: var(--footer-bg);
    color: var(--footer-text);
    padding: 2.5rem 5% 2rem;
    margin-top: 4rem;
    position: relative;
}

footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
}

.footer-content {
    display: grid;
    grid-template-columns: 1.5fr 2fr 1.5fr;
    gap: 4rem;
    max-width: 1200px;
    margin: 0 auto;
}

.footer-section {
    padding: 0 1rem;
}

.footer-section.brand h3 {
    font-size: 1.8rem;
    margin-bottom: 1rem;
    color: var(--white);
}

.footer-section.brand span {
    color: var(--primary-color);
}

.social-links {
    margin-top: 1.5rem;
    display: flex;
    gap: 1rem;
}

.social-links a {
    color: var(--footer-text);
    font-size: 1.5rem;
    transition: var(--transition);
}

.social-links a:hover {
    color: var(--primary-color);
    transform: translateY(-3px);
}

.two-column-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.footer-section.links h3 {
    margin-bottom: 1.5rem;
    color: var(--white);
}

.footer-section.links a {
    color: var(--footer-text);
    text-decoration: none;
    display: block;
    margin-bottom: 0.8rem;
    transition: var(--transition);
}

.footer-section.links a:hover {
    color: var(--primary-color);
    transform: translateX(5px);
}

.footer-section.contact h3 {
    margin-bottom: 1.5rem;
    color: var(--white);
}

.contact-info p {
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.contact-info i {
    color: var(--primary-color);
}

.footer-bottom {
    text-align: center;
    padding-top: 2rem;
    margin-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}
</style>

</head>

<body>
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
                    <a href="index.php#home">Home</a>
                    <a href="services.php">Services</a>
                    <a href="index.php#store">Store</a>
                    <a href="index.php#about">About</a>
                </div>
                <div>
                    <a href="index.php#privacy">Privacy Policy</a>
                    <a href="index.php#terms">Terms of Service</a>
                    <a href="faq.php">FAQ</a>
                    <a href="index.php#support">Support</a>
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
</body>

