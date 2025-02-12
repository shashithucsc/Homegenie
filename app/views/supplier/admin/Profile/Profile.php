<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Profile</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierProfile.css">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .hg-supplier-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header1 h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        /* Profile Info Section */
        .hg-supplier-info {
            display: flex;
            align-items: center;
            gap: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .hg-supplier-info img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid #007bff;
            object-fit: cover;
        }

        .profile-details {
            flex: 1;
        }

        .profile-details h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .profile-details p {
            font-size: 16px;
            color: #555;
            margin: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-details p i {
            color: #007bff;
            font-size: 18px;
        }

        /* Edit Button */
        .edit-button {
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .edit-button:hover {
            background-color: #0056b3;
        }

        /* Edit Section (Hidden by Default) */
        .hg-supplier-actions {
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: none; /* Hidden by default */
        }

        .hg-supplier-actions h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 15px;
        }

        .hg-supplier-actions form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .hg-supplier-actions label {
            font-size: 16px;
            color: #555;
        }

        .hg-supplier-actions input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .hg-supplier-actions button {
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .hg-supplier-actions button:hover {
            background-color: #0056b3;
        }

        /* Message Box */
        .message-box {
            padding: 15px;
            background: #e9f5ff;
            border-left: 4px solid #007bff;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .message-box p {
            margin: 0;
            color: #333;
            font-size: 16px;
        }
    </style>
</head>
<body>
<?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>
    <div class="hg-supplier-container">
        <div class="header1">
            <h1>Supplier Profile</h1>
        </div>
        <main>
            <?php if (!empty($data['message'])): ?>
                <div class="message-box">
                    <p><?php echo $data['message']; ?></p>
                </div>
            <?php endif; ?>

            <!-- Profile Info Section -->
            <section class="hg-supplier-info">
            <?php if (!empty($data['supplier']->profile_image)): ?>
                <img src="data:image/png;base64,<?php echo base64_encode($data['supplier']->profile_image); ?>" alt="Profile Picture">

<?php else: ?>
    <img src="<?php echo URLROOT; ?>/public/images/default-profile.png" alt="Default Profile Picture">
<?php endif; ?>

                <div class="profile-details">
                    <h2><?php echo htmlspecialchars($data['supplier']->first_name . ' ' . $data['supplier']->last_name); ?></h2>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($data['supplier']->email); ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($data['supplier']->contact_number); ?></p>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($data['supplier']->address); ?></p>
                    <p><i class="fas fa-tools"></i> <?php echo htmlspecialchars($data['supplier']->expertise); ?></p>
                    <p><i class="fas fa-map"></i> <?php echo htmlspecialchars($data['supplier']->service_areas); ?></p>
                </div>
            </section>

            <!-- Edit Button -->
            <button class="edit-button" onclick="toggleEditSection()">Edit Profile</button>

            <!-- Edit Section -->
            <section id="edit-section" class="hg-supplier-actions">
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

    <script>
        // JavaScript function to toggle the visibility of the edit section
        function toggleEditSection() {
            const editSection = document.getElementById('edit-section');
            if (editSection.style.display === 'none' || editSection.style.display === '') {
                editSection.style.display = 'block'; // Show the edit section
            } else {
                editSection.style.display = 'none'; // Hide the edit section
            }
        }
    </script>
</body>
</html>