<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Profile</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierProfile.css">
</head>
<body>
<?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>
    <div class="hg-supplier-container">
        <duv class="header1">
            <h1>Supplier Profile</h1>
        </duvheader>
        <main>
            <?php if (!empty($data['message'])): ?>
                <div class="message-box">
                    <p><?php echo $data['message']; ?></p>
                </div>
            <?php endif; ?>

            <section class="hg-supplier-info">
                <?php if (!empty($data['supplier']->profile_image)): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($data['supplier']->profile_image); ?>" alt="Profile Picture">
                <?php else: ?>
                    <img src="<?php echo URLROOT; ?>/public/images/default-profile.png" alt="Default Profile Picture">
                <?php endif; ?>
                <h2><?php echo htmlspecialchars($data['supplier']->first_name . ' ' . $data['supplier']->last_name); ?></h2>
                <p>Email: <?php echo htmlspecialchars($data['supplier']->email); ?></p>
                <p>Contact: <?php echo htmlspecialchars($data['supplier']->contact_number); ?></p>
                <p>Address: <?php echo htmlspecialchars($data['supplier']->address); ?></p>
                <p>Expertise: <?php echo htmlspecialchars($data['supplier']->expertise); ?></p>
                <p>Service Areas: <?php echo htmlspecialchars($data['supplier']->service_areas); ?></p>
            </section>

            <section class="hg-supplier-actions">
                <h3>Update Profile</h3>
                <form action="<?php echo URLROOT; ?>/SupplierController/updateProfile" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $data['supplier']->user_id; ?>">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($data['supplier']->first_name); ?>" required>
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($data['supplier']->last_name); ?>" required>
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" name="contact_number" value="<?php echo htmlspecialchars($data['supplier']->contact_number); ?>" required>
                    <label for="address">Address:</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($data['supplier']->address); ?>" required>
                    <label for="expertise">Expertise:</label>
                    <input type="text" name="expertise" value="<?php echo htmlspecialchars($data['supplier']->expertise); ?>">
                    <label for="service_areas">Service Areas:</label>
                    <input type="text" name="service_areas" value="<?php echo htmlspecialchars($data['supplier']->service_areas); ?>">
                    <button type="submit">Save Changes</button>
                </form>

                <h3>Update Profile Picture</h3>
                <form action="<?php echo URLROOT; ?>/SupplierController/updateProfilePicture" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?php echo $data['supplier']->user_id; ?>">
                    <input type="file" name="profile_image" accept="image/*" required>
                    <button type="submit">Upload Picture</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
