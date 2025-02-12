<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="nav-container">
    <nav class="navbar">
        <div class="logo">Home<span>Genie</span></div>
        <div class="nav-links">
            <a href="<?php echo URLROOT; ?>/ServiceProviderController/index"
                class="nav-item <?= $current_page == 'appointments.php' ? 'active' : '' ?>"
                id="appointments-link">Appointments</a>
            <a href="<?php echo URLROOT; ?>/ServiceProviderController/quotation"
                class="nav-item <?= $current_page == 'quotation.php' ? 'active' : '' ?>"
                id="quotation-link">Quotation</a>
            <a href="../../supplier/HomeController.php"
                class="nav-item <?= $current_page == 'store.php' ? 'active' : '' ?>" id="store-link">Store</a>
            <a href="<?php echo URLROOT; ?>/ServiceProviderController/support"
                class="nav-item <?= $current_page == 'support.php' ? 'active' : '' ?>" id="support-link">Support</a>
            <a href="<?php echo URLROOT; ?>/ServiceProviderController/profile"
                class="nav-item <?= $current_page == 'profile.php' ? 'active' : '' ?>" id="profile-link">Profile</a>
        </div>
        <div class="user-info">
            <img src="<?php echo isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : URLROOT . '/public/img/SVPpic/default_user.png'; ?>"
                alt="User Profile" class="profile-pic">
            <span class="user-name"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></span>
            <button onclick="location.href='<?php echo URLROOT; ?>/users/login'" class="logout-btn"
                style="color: white;">Logout</button>
        </div>
    </nav>
</div>

<style>
    :root {
        --body-color: #ffffff;
        --main-color: #1e40af;
        --primary-color: #2563eb;
        --primary-color-light: #ffffff;
        --light-green: #3b82f6;
        --toggle-color: #DDD;
        --text-color: #ffffff;
        --black: #000;
        --hover-color: rgba(38, 99, 235, 0.1);
        /* Light hover effect */
        --shadow-color: rgba(0, 0, 0, 0.1);
        /* Shadow for navbar */
    }

    body {
        font-family: 'Inter', sans-serif;
        margin: 0;
        padding: 0;
        background-color: var(--body-color);
        color: var(--black);
    }

    .nav-container {
        background-color: var(--body-color);
        color: var(--main-color);
        box-shadow: 0 2px 4px var(--shadow-color);
    }

    .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 20px;
        /* Increased padding for a more spacious feel */
    }

    .logo {
        font-size: 28px;
        /* Slightly smaller logo size */
        font-weight: bold;
        color: var(--main-color);
        transition: color 0.3s;
    }

    .logo span {
        color: var(--light-green);
        opacity: 0.9;
    }

    .nav-links {
        display: flex;
        gap: 25px;
        /* Increased gap for better spacing */
    }

    .nav-item {
        color: var(--main-color);
        text-decoration: none;
        font-size: 18px;
        /* Slightly smaller font size */
        position: relative;
        padding: 10px 15px;
        /* Increased padding */
        transition: background-color 0.3s, color 0.3s;
        /* Smooth transition for hover effects */
        border-radius: 5px;
        /* Rounded corners */
    }

    .nav-item.active {
        font-weight: 600;
        color: var(--light-green);
        /* Change active link color */
    }

    .nav-item:hover {
        background-color: var(--hover-color);
        /* Light background on hover */
        color: var(--light-green);
        /* Change text color on hover */
        border-radius: 5px;
        /* Rounded corners on hover */
    }

    .user-info {
        font-size: 18px;
        /* Slightly smaller font size */
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .span {
        padding-right: 10px;
        color: var(--main-color);
    }

    .profile-pic {
        width: 40px;
        /* Slightly larger profile image */
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--main-color);
        transition: border-color 0.3 s;
        /* Smooth transition for border color */
    }

    .profile-pic:hover {
        border-color: var(--light-green);
        /* Change border color on hover */
    }

    .logout-btn {
        background-color: var(--main-color);
        font-size: 15px;
        border: none;
        padding: 8px 12px;
        border-radius: 20px;
        color: var(--text-color);
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        /* Smooth transition for hover effects */
    }

    .logout-btn:hover {
        background-color: var(--light-green);
        /* Change background color on hover */
        transform: scale(1.05);
        /* Slightly enlarge button on hover */
    }

    /* Style the active link */
    .nav-link.active {
        text-decoration: underline;
        font-weight: bold;
        /* Optional, you can customize it further */
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const currentPath = window.location.pathname;
        const navItems = document.querySelectorAll('.nav-item');

        navItems.forEach(item => {
            if (item.href === window.location.href) {
                item.classList.add('active');
            }

            item.addEventListener('click', function () {
                navItems.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>