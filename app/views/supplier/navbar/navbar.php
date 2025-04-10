<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>


<body>
    <header class="top-nav">
        <div class="logo">
            <img src="<?php echo URLROOT; ?>/public/img/logo.png" alt="HomeGenie Logo" class="circle-logo">
            <h1>HomeGenie Store</h1>
        </div>
        <nav>
            <ul>
                <li><a href="<?php echo URLROOT; ?>/StorePageController/index" target="main">Home</a></li>
                <li><a href="<?php echo URLROOT; ?>/StorePageController/wishList" target="main">WishList</a></li>
                <li><a href="<?php echo URLROOT; ?>/StorePageController/viewCart" target="main">Your Cart</a></li>
                <li><a href="<?php echo URLROOT; ?>/StorePageController/myOrders" target="main">My Orders</a></li>
                <li><a href="<?php echo URLROOT; ?>/StorePageController/aboutUs" target="main">About Us</a></li>
            </ul>
        </nav>
        <div class="user-profile">
            <img src="<?php echo isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : URLROOT . '/public/img/profile.png'; ?>" alt="User Profile" class="profile-pic">
            <span class="user-name"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></span>
        </div>


        <a class="logout-button" href="<?php echo URLROOT; ?>/LoginController/logout">Log out</a>
    </header>
?>


