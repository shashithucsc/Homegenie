<?php
require_once '../db.php';

// Fetch service providers
$query = "SELECT * FROM users WHERE account_type_id = 2";
$stmt = $conn->prepare($query);
$stmt->execute();
$serviceProviders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$serviceProviders) {
    echo "No service providers found.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - HomeGenie</title>
    <link rel="stylesheet" href="../../css/services.css">
    <link rel="stylesheet" href="../../css/style-index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
<nav class="top-nav">
        <a href="index.php" class="nav-brand">Home<span>Genie</span></a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="services.php">Services</a>
            <a href="../../../supplier/HomeController.php">Store</a>
            <a href="about.php">About</a>
            <button onclick="document.location='../login/login.php'" class="login-btn">Login</button>
        </div>
    </nav>

    <div class="search-container">
        <div class="search-wrapper">
            <i class='bx bx-search search-icon'></i>
            <input type="text" id="searchInput" placeholder="Search for services..." aria-label="Search services">
            <button id="clearSearch" class="clear-search" aria-label="Clear search">
                <i class='bx bx-x'></i>
            </button>
        </div>
    </div>

    <main class="main-content">
        <div class="filter-sidebar">
            <div class="filter-header">
                <h2>Filters</h2>
                <button id="resetFilters" class="reset-filters">
                    <i class='bx bx-undo'></i> Reset
                </button>
            </div>

            <div class="filter-section">
                <h3>Service Type</h3>
                <div class="filter-options">
                    <label class="filter-option">
                        <input type="radio" name="category" value="" checked>
                        <span class="radio-label">All Services</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="category" value="Plumbing">
                        <span class="radio-label">Plumbing</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="category" value="Electrical">
                        <span class="radio-label">Electrical</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="category" value="Cleaning">
                        <span class="radio-label">Cleaning</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="category" value="Painting">
                        <span class="radio-label">Painting</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="category" value="Gardening">
                        <span class="radio-label">Gardening</span>
                    </label>
                </div>
            </div>

            <div class="filter-section">
                <h3>Minimum Rating</h3>
                <div class="filter-options">
                    <label class="filter-option">
                        <input type="radio" name="rating" value="" checked>
                        <span class="radio-label">Any Rating</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="rating" value="4.5">
                        <span class="radio-label">4.5+ Stars</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="rating" value="4">
                        <span class="radio-label">4+ Stars</span>
                    </label>
                    <label class="filter-option">
                        <input type="radio" name="rating" value="3">
                        <span class="radio-label">3+ Stars</span>
                    </label>
                </div>
            </div>

            <button id="toggleFilters" class="toggle-filters">
                <i class='bx bx-filter-alt'></i>
                <span>Filters</span>
            </button>
        </div>

        <section id="services" class="services-section">
            <div class="services-grid" id="servicesGrid">
                <!-- <div class="service-card" id=""> -->
                <?php foreach ($serviceProviders as $provider): ?>
                    <div class="service-card" id="<?php echo htmlspecialchars($provider['id']); ?>">
                        <img src="../register/uploads/<?php echo htmlspecialchars($provider['profile_image']); ?>"
                            alt="<?php echo htmlspecialchars($provider['first_name'] . ' ' . $provider['last_name']); ?>"
                            class="service-image">
                        <div class="service-content">
                            <h3><?php echo htmlspecialchars($provider['first_name'] . ' ' . $provider['last_name']); ?>
                            </h3>
                            <span class="service-type"><?php echo htmlspecialchars($provider['expertise']); ?></span>
                            <div class="rating" aria-label="4.8 out of 5 stars">
                                <span class="rating-number">4.8</span>
                            </div>
                            <p><?php echo htmlspecialchars($provider['description']); ?></p>
                            <a href="sp_profile.php?id=<?php echo htmlspecialchars($provider['id']); ?>">
                                <div class="contact-btn">
                                    More Info <i class='bx bx-right-arrow-alt'></i>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- </div> -->
        </section>
    </main>

    <script type="module" src="src/js/services.js"></script>
    <script type="module" src="../../js/script-index.js"></script>
</body>

</html>