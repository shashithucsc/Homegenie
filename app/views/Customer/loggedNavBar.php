<nav>
    <a href="cu_home.php" class="nav-brand">Home<span>Genie</span></a>
    <div class="nav-links">
        <a href="<?php echo URLROOT; ?>/CustomerController">Home</a>
        <a href="<?php echo URLROOT; ?>/CustomerController/services">Services</a>
        <a href="<?php echo URLROOT; ?>/StorePageController">Store</a>
        <a href="<?php echo URLROOT; ?>/CustomerController/about">About</a>
        <div class="profile-container">
            <span class="name"><?php echo htmlspecialchars($user_name); ?></span>
            <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-image">
            <div class="profile-dropdown">
                <a href="<?php echo URLROOT; ?>/CustomerController/profile"><i class='bx bx-user'></i> My Profile</a>
                <a href="<?php echo URLROOT; ?>/LoginController/logout"><i class='bx bx-log-out'></i> Logout</a>
            </div>
        </div>
    </div>
</nav>