<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Profile</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierProfile.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierSidebar.css">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
</head>
<body>
<?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>
    
    <div class="profile-container">
       
        <div class="profile-header">
            <div class="profile-cover">
                <div class="profile-image-wrapper">
                    <?php if (!empty($data['supplier']->profile_image)): ?>
                        <img src="data:image/png;base64,<?php echo base64_encode($data['supplier']->profile_image); ?>" alt="Profile Picture" class="profile-image">
                    <?php else: ?>
                        <img src="<?php echo URLROOT; ?>/public/images/default-profile.png" alt="Default Profile Picture" class="profile-image">
                    <?php endif; ?>
                    <button class="edit-profile-btn" onclick="toggleEditSection()">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                </div>
            </div>
            <div class="profile-info-header">
                <h1 class="profile-name"><?php echo htmlspecialchars($data['supplier']->first_name . ' ' . $data['supplier']->last_name); ?></h1>
                <p class="profile-role">Supplier</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="profile-content">
            <!-- Left Column -->
            <div class="profile-left">
                <!-- Contact Information -->
                <div class="info-card">
                    <h2 class="card-title">Contact Information</h2>
                    <div class="info-group">
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <div class="info-content">
                                <span class="info-label">Email</span>
                                <span class="info-value"><?php echo htmlspecialchars($data['supplier']->email); ?></span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <div class="info-content">
                                <span class="info-label">Phone</span>
                                <span class="info-value"><?php echo htmlspecialchars($data['supplier']->contact_number); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="info-card">
                    <h2 class="card-title">Address</h2>
                    <div class="info-group">
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="info-content">
                                <span class="info-label">Street</span>
                                <span class="info-value"><?php echo htmlspecialchars($data['supplier']->street); ?></span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-city"></i>
                            <div class="info-content">
                                <span class="info-label">District</span>
                                <span class="info-value"><?php echo htmlspecialchars($data['supplier']->district); ?></span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-globe"></i>
                            <div class="info-content">
                                <span class="info-label">Province</span>
                                <span class="info-value"><?php echo htmlspecialchars($data['supplier']->province); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="profile-right">
                <!-- Business Information -->
                <div class="info-card">
                    <h2 class="card-title">Business Information</h2>
                    <div class="info-group">
                        <div class="info-item">
                            <i class="fas fa-tools"></i>
                            <div class="info-content">
                                <span class="info-label">Expertise</span>
                                <span class="info-value"><?php echo htmlspecialchars($data['supplier']->expertise); ?></span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-id-card"></i>
                            <div class="info-content">
                                <span class="info-label">NIC</span>
                                <span class="info-value"><?php echo htmlspecialchars($data['supplier']->NIC); ?></span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <div class="info-content">
                                <span class="info-label">Bank Details</span>
                                <span class="info-value"><?php echo htmlspecialchars($data['supplier']->bank_details); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="info-card">
                    <h2 class="card-title">About</h2>
                    <div class="info-group">
                        <div class="info-item">
                            <i class="fas fa-info-circle"></i>
                            <div class="info-content">
                                <span class="info-label">Description</span>
                                <span class="info-value"><?php echo htmlspecialchars($data['supplier']->description); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Section -->
        <div id="edit-section" class="edit-section">
            <?php if (!empty($data['message'])): ?>
                <div class="message-box">
                    <p><?php echo $data['message']; ?></p>
                </div>
            <?php endif; ?>

            <div class="edit-forms">
                <!-- Profile Update Form -->
                <form action="<?php echo URLROOT; ?>/SupplierController/updateProfile" method="POST" class="edit-form">
                    <h2>Update Profile Information</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first_name">First Name <span class="required">*</span></label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($data['supplier']->first_name); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name <span class="required">*</span></label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($data['supplier']->last_name); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_number">Contact Number <span class="required">*</span></label>
                            <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($data['supplier']->contact_number); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="street">Street <span class="required">*</span></label>
                            <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($data['supplier']->street); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="district">District <span class="required">*</span></label>
                            <input type="text" id="district" name="district" value="<?php echo htmlspecialchars($data['supplier']->district); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Province <span class="required">*</span></label>
                            <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($data['supplier']->province); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="expertise">Expertise</label>
                            <input type="text" id="expertise" name="expertise" value="<?php echo htmlspecialchars($data['supplier']->expertise); ?>">
                        </div>
                        <div class="form-group">
                            <label for="NIC">NIC</label>
                            <input type="text" id="NIC" name="NIC" value="<?php echo htmlspecialchars($data['supplier']->NIC); ?>">
                        </div>
                        <div class="form-group">
                            <label for="bank_details">Bank Details</label>
                            <input type="text" id="bank_details" name="bank_details" value="<?php echo htmlspecialchars($data['supplier']->bank_details); ?>">
                        </div>
                        <div class="form-group full-width">
                            <label for="description">Description</label>
                            <textarea id="description" name="description"><?php echo htmlspecialchars($data['supplier']->description); ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo $data['supplier']->user_id; ?>">
                    <div class="form-actions">
                        <button type="submit" class="save-button">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>

                <!-- Profile Picture Update Form -->
                <form action="<?php echo URLROOT; ?>/SupplierController/updateProfilePicture" method="POST" enctype="multipart/form-data" class="edit-form">
                    <h2>Update Profile Picture</h2>
                    <div class="form-group">
                        <label for="profile_image">Profile Picture</label>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*" required>
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo $data['supplier']->user_id; ?>">
                    <div class="form-actions">
                        <button type="submit" class="save-button">
                            <i class="fas fa-upload"></i> Upload Picture
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleEditSection() {
            const editSection = document.getElementById('edit-section');
            if (editSection.style.display === 'none' || editSection.style.display === '') {
                editSection.style.display = 'block';
                window.scrollTo({
                    top: editSection.offsetTop,
                    behavior: 'smooth'
                });
            } else {
                editSection.style.display = 'none';
            }
        }
    </script>
</body>
</html>