<nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                <img src="<?php echo URLROOT; ?>/public/img/logo.png" alt="logo">
                </span>
                <div class="text header-text">
                    <span class="website">HOMEGENIE</span>
                </div>
            </div>

            <i class='bx bx-chevron-right icon toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link active">
                    <a href="<?php echo URLROOT; ?>/AdminController/index" target="main" class="nav-link">
                            <i class='bx bx-line-chart icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                    <a href="<?php echo URLROOT; ?>/AdminController/manageUsers" target="main" class="nav-link">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Manage Users</span>
                        </a>
                    </li>
                    <li class="nav-link">
                    <a href="<?php echo URLROOT; ?>/AdminController/verifyUsers" target="main" class="nav-link">
                            <i class='bx bxs-user-check icon'></i>
                            <span class="text nav-text">Verify Users</span>
                        </a>
                    </li>
                    <li class="nav-link">
                    <a href="<?php echo URLROOT; ?>/AdminController/Issues" target="main" class="nav-link">
                            <i class='bx bx-error icon'></i>
                            <span class="text nav-text">View Issues</span>
                        </a>
                    </li>
                    <li class="nav-link">
                    <a href="<?php echo URLROOT; ?>/AdminController/viewOrders" target="main" class="nav-link">
                            <i class='bx bx-package icon'></i>
                            <span class="text nav-text">View Orders</span>
                        </a>
                    </li>
                    <li class="nav-link">
                    <a href="<?php echo URLROOT; ?>/AdminController/faq" target="main" class="nav-link">
                            <i class='bx bx-question-mark icon'></i>
                            <span class="text nav-text">Manage FAQ</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <li class="log-out">
                    <a href="<?php echo URLROOT; ?>/LoginController/logout" class="log-out">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>