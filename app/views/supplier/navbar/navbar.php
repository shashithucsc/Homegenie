<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<body>
    <header class="top-nav">
        <div class="logo">
            <a href="<?php echo URLROOT; ?>/CustomerController/index">
                <img src="<?php echo URLROOT; ?>/public/img/logo.png" alt="HomeGenie Logo" class="circle-logo">
            </a>
            <h1>HomeGenie Store</h1>
        </div>

        <nav>
            <ul>
                <li><a href="<?php echo URLROOT; ?>/CustomerController/index"><i class="fas fa-globe"></i>
                    </a></li>
                <li><a href="<?php echo URLROOT; ?>/StorePageController/index"><i class="fas fa-home"></i>
                        Home</a></li>
                <li><a href="<?php echo URLROOT; ?>/StorePageController/wishList" ><i
                            class="fas fa-heart"></i>
                        WishList</a></li>
                <li><a href="<?php echo URLROOT; ?>/StorePageController/viewCart"><i
                            class="fas fa-shopping-cart"></i>
                        Your Cart</a></li>
                <li><a href="<?php echo URLROOT; ?>/StorePageController/myOrders"><i
                            class="fas fa-box"></i>
                        My Orders</a></li>
                <li><a href="<?php echo URLROOT; ?>/StorePageController/support"><i
                            class="fas fa-info-circle"></i>
                        Support</a></li>
            </ul>
        </nav>

        <div class="user-dropdown">
            <div class="user-profile" onclick="toggleDropdown()">
                <?php if (isset($_SESSION['profile_pic'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['profile_pic']); ?>" alt="Profile Picture" class="profile-pic">
                <?php else: ?>
                    <img src="<?php echo URLROOT; ?>/public/img/profile.png" alt="Profile Picture" class="profile-pic">
                <?php endif; ?>
                <span class="user-name">
                    <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>
                </span>
            </div>

            <?php if (isset($_SESSION['username'])): ?>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a class="logout-button" href="<?php echo URLROOT; ?>/LoginController/logout">
                        <i class="fas fa-sign-out-alt"></i> Log out
                    </a>
                </div>
            <?php else: ?>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a class="login-button" href="<?php echo URLROOT; ?>/LoginController/index">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </header>
</body>