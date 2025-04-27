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
    <title>Contact Us - HomeServe Hub</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style-contact.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navigationbar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php require_once APPROOT . '/views/Customer/loggedNavBar.php'; ?>
    <main class="contact-page">
        <section class="contact-hero">
            <div class="container">
                <h1>Get in Touch</h1>
                <p>We're here to help and answer any questions you might have</p>
            </div>
        </section>

        <section class="contact-content">
            <div class="container">
                <div class="contact-grid">
                    <div class="contact-form-container">
                        <h2>Send us a Message</h2>
                        <form id="contactForm" class="contact-form" method="POST" action="<?php echo URLROOT . '/CustomerController/contact';?>">
                            <div class="form-group">
                                <label for="name">Full Name <span class="required">*</span></label>
                                <input type="text" id="name" name="full_name" required>
                                <span class="error-message" id="nameError"></span>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address <span class="required">*</span></label>
                                <input type="email" id="email" name="email" required>
                                <span class="error-message" id="emailError"></span>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone">
                                <span class="error-message" id="phoneError"></span>
                            </div>

                            <div class="form-group">
                                <label for="subject">Subject <span class="required">*</span></label>
                                <select id="subject" name="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="support">Technical Support</option>
                                    <option value="partnership">Partnership Opportunity</option>
                                    <option value="feedback">Feedback</option>
                                </select>
                                <span class="error-message" id="subjectError"></span>
                            </div>

                            <div class="form-group">
                                <label for="message">Message <span class="required">*</span></label>
                                <textarea id="message" name="message" rows="5" required></textarea>
                                <span class="error-message" id="messageError"></span>
                            </div>

                            <button type="submit" class="submit-btn">
                                <span>Send Message</span>
                                <i class='bx bxs-paper-plane'></i>
                            </button>
                        </form>
                    </div>

                    <div class="contact-info-container">
                        <div class="contact-info">
                            <h2>Contact Information</h2>

                            <div class="info-card">
                                <i class='bx bxs-map'></i>
                                <div class="info-content">
                                    <h3>Location</h3>
                                    <p>No.123</p>
                                    <p>Colombo Road, Galle</p>
                                    <p>Sri Lanka</p>
                                </div>
                            </div>

                            <div class="info-card">
                                <i class='bx bxs-phone'></i>
                                <div class="info-content">
                                    <h3>Phone</h3>
                                    <p>Main: (+94) 700000000</p>
                                    <p>Support: (+94) 700000001</p>
                                </div>
                            </div>

                            <div class="info-card">
                                <i class='bx bxs-envelope'></i>
                                <div class="info-content">
                                    <h3>Email</h3>
                                    <p>info@homegenie.com</p>
                                    <p>support@homegenie.com</p>
                                </div>
                            </div>

                            <div class="social-links">
                                <h3>Follow Us</h3>
                                <div class="social-icons">
                                    <a href="#" aria-label="Facebook"><i class='bx bxl-facebook-circle'></i></a>
                                    <a href="#" aria-label="Twitter"><i class='bx bxl-twitter'></i></i></a>
                                    <a href="#" aria-label="Instagram"><i class='bx bxl-instagram-alt'></i></i></a>
                                    <a href="#" aria-label="LinkedIn"><i class='bx bxl-linkedin-square'></i></a>
                                    <a href="#" aria-label="Github"><i class='bx bxl-github'></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d912.773822297324!2d79.8609428612646!3d6.902196943616361!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25963120b1509%3A0x2db2c18a68712863!2sUniversity%20of%20Colombo%20School%20of%20Computing%20(UCSC)!5e0!3m2!1sen!2sus!4v1733034972320!5m2!1sen!2sus"
                                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <i class='bx bxs-check-circle'></i>
                <h2>Thank You!</h2>
                <p>Your message has been sent successfully. We'll get back to you soon.</p>
                <button class="modal-btn">Close</button>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-bottom">
            <p>&copy; 2024 HomeServeHub. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>