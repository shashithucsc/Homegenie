<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="nav-container" id="main-content">
    <nav class="navbar">
        <div class="logo">Home<span>Genie</span></div>
        <div class="nav-links">
            <a href="<?php echo URLROOT; ?>/ServiceProviderController/index"
                class="nav-item <?= $current_page == 'appointments.php' ? 'active' : '' ?>" id="appointments-link">Appointments</a>
            <a href="<?php echo URLROOT; ?>/ServiceProviderController/quotation"
                class="nav-item <?= $current_page == 'quotation.php' ? 'active' : '' ?>" id="quotation-link">Quotation</a>
            <a href="../../supplier/HomeController.php"
                class="nav-item <?= $current_page == 'store.php' ? 'active' : '' ?>" id="store-link">Store</a>
            <a href="<?php echo URLROOT; ?>/ServiceProviderController/support"
                class="nav-item <?= $current_page == 'support.php' ? 'active' : '' ?>" id="support-link">Support</a>
            <a href="<?php echo URLROOT; ?>/ServiceProviderController/profile"
                class="nav-item <?= $current_page == 'profile.php' ? 'active' : '' ?>" id="profile-link">Profile</a>
        </div>
        <div class="user-info">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['profile_pic']); ?>"
                alt="User Profile" class="profile-pic">
            <span class="user-name"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></span>
            <button onclick="showLogoutModal()" class="logout-btn">Logout</button>
        </div>
    </nav>
</div>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="modal-overlay">
    <div class="modal-content">
        <p>Are you sure you want to logout?</p>
        <div class="modal-buttons">
            <button onclick="confirmLogout()">Yes</button>
            <button onclick="hideLogoutModal()">Cancel</button>
        </div>
    </div>
</div>

<style>
    /* === COLORS AND BASE === */
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
        --shadow-color: rgba(0, 0, 0, 0.1);
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
    }

    .logo {
        font-size: 28px;
        font-weight: bold;
        color: var(--main-color);
    }

    .logo span {
        color: var(--light-green);
        opacity: 0.9;
    }

    .nav-links {
        display: flex;
        gap: 25px;
    }

    .nav-item {
        color: var(--main-color);
        text-decoration: none;
        font-size: 18px;
        position: relative;
        padding: 10px 15px;
        transition: background-color 0.3s, color 0.3s;
        border-radius: 5px;
    }

    .nav-item.active {
        font-weight: 600;
        color: var(--light-green);
    }

    .nav-item:hover {
        background-color: var(--hover-color);
        color: var(--light-green);
        border-radius: 5px;
    }

    .user-info {
        font-size: 18px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-pic {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--main-color);
    }

    .profile-pic:hover {
        border-color: var(--light-green);
    }

    .logout-btn {
        background-color: var(--main-color);
        font-size: 15px;
        border: none;
        padding: 8px 12px;
        border-radius: 20px;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
    }

    .logout-btn:hover {
        background-color: var(--light-green);
        transform: scale(1.05);
    }

    /* === MODAL === */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        background-color: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(5px);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 999;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
        min-width: 300px;
    }

    .modal-content p {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .modal-buttons button {
        background-color: var(--main-color);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        margin: 0 10px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .modal-buttons button:hover {
        background-color: var(--light-green);
    }
</style>

<script>
    function showLogoutModal() {
        document.getElementById('logoutModal').classList.add('active');
    }

    function hideLogoutModal() {
        document.getElementById('logoutModal').classList.remove('active');
    }

    function confirmLogout() {
        window.location.href = "<?php echo URLROOT; ?>/Users/logout";
    }

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
