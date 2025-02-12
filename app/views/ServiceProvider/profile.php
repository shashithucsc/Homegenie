<?php
require_once APPROOT . '/views/ServiceProvider/navbar_svp.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Service Provider</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SVP/SVP_Profile.css">
</head>

<body>
    <?php $row = isset($data['row']) ? $data['row'] : null; ?>

    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <h1><?php echo htmlspecialchars($row->first_name . ' ' . $row->last_name); ?></h1>
        </div>

        <!-- Profile Info -->
        <div class="profile-info">
            <!-- Profile Image -->
            <div class="profile-image">
                <img src="<?php echo URLROOT . '/public/img/default_user.png'; ?>" alt="Profile Image">
            </div>

            <!-- User Ratings (Dummy UI) -->
            <div class="rating">
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">☆</span>
            </div>
            <h3>Profile Information</h3>
            <div style="text-align: center;">
                <p><strong>Full Name:</strong>
                    <?php echo htmlspecialchars($row->first_name . ' ' . $row->last_name); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($row->email); ?></p>
                <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($row->contact_number); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($row->address); ?></p>
                <p><strong>Expertise:</strong> <?php echo htmlspecialchars($row->expertise); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($row->description); ?></p>
                <p><strong>Service Areas :</strong> <?php echo htmlspecialchars($row->service_areas); ?></p>
                <p><strong>Working Hours:</strong> <?php echo htmlspecialchars($row->working_hours); ?></p>
            </div>
        </div>

        <!-- Work Photos Section -->
        <div class="work-photos">
            <h3>Working Photos</h3>
            <div class="image-row">
                <?php
                $work_photos = explode(",", $row->work_photos);
                foreach ($work_photos as $photo) {
                    echo '<div class="image-tile"><img src="' . URLROOT . '/public/img/SVPpic/' . htmlspecialchars($photo) . '" alt="Work Photo"></div>';
                }
                ?>
            </div>
        </div>

        <a href="edit_profile.php" class="update-button">Edit Profile</a>
    </div>
</body>

</html>

<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>